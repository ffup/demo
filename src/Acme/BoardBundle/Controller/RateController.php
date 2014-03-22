<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RateController extends Controller
{

    public function increaseAction(Request $request)
    {
        // $request->isXmlHttpRequest(); // is it an Ajax request?
        $commentId = $request->request->get('comment_id');    
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();
        $user = $this->getUser();
        
        if (!isset($user) || false == preg_match('/^\d+$/', $commentId)) {
            return $response;
        }
        
        $comment = $em->getRepository('AcmeBoardBundle:Comment')->find($commentId);
        
        if (false == $comment) {
            return $response;
        }
        
        $repo = $em->getRepository('AcmeBoardBundle:CommentTrack');
        $track = $repo->find(array('user' => $user->getId(),
            'comment' => $comment->getId(),));
     
        if (isset($track) && $track->getHasVoted()) {
            return $response;
        }
          
        $repo->create($user, $comment);
              
        $data = array(
                    "code"    => 100, 
                    "success" => true, 
                    "votes"   => $comment->getVotes()
                );
                
        $response->setData($data);
        return $response;
    }

}
