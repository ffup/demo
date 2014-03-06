<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RateController extends Controller
{
    public function increaseAction(Request $request)
    {
        $request->isXmlHttpRequest(); // is it an Ajax request?

        $commentId = $request->request->get('comment_id');    
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AcmeBoardBundle:Comment')->find($commentId);
        $response = new JsonResponse();
        
        if (!$comment) {
            return $response;
        }
        
        $comment->setVotes($comment->getVotes() + 1);
        $em->persist($comment);               
        $em->flush();
              
        $data = array("code" => 100, 
            "success" => true, 
            "votes" => $comment->getVotes());
        $response->setData($data);
        return $response;
        
        // Test
        $params = array();
        return $this->render('AcmeBoardBundle:Rate:increase.html.twig', $params);
    }

}
