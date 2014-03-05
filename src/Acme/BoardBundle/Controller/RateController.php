<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RateController extends Controller
{
    public function increaseAction(Request $request)
    {
    
        $data1 = $request->query->get('comment_id');

        
        $data = array("code" => 100, "success" => true);

        
        $response = new JsonResponse();
        $response->setData($data);
        
        return $response;
        
        $params = array();
        return $this->render('AcmeBoardBundle:Rate:increase.html.twig', $params);
    }

}
