<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AsynchronyController extends Controller
{
    public function voteAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        // $request->isXmlHttpRequest(); // is it an Ajax request?
        $commentId = $request->request->get('comment_id');    
        $response = new JsonResponse();
        
        if (false == preg_match('/^\d+$/', $commentId)) {
            return $response;
        }
        
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AcmeBoardBundle:Comment')->find($commentId);
        
        if (false == $comment) {
            return $response;
        }
        
        $repo = $em->getRepository('AcmeBoardBundle:CommentTrack');
        $track = $repo->find(array(
            'user' => $this->getUser()->getId(),
            'comment' => $comment->getId()
        ));
        
        if (isset($track)) {
            $repo->vote($track);            
        } else {
            $repo->create($this->getUser(), $comment);
        }
                
        $data = array(
                    "code"    => 100, 
                    "success" => true, 
                    "votes"   => $comment->getVotes()
                );
                
        $response->setData($data);
        
        return $response;
    }
}
