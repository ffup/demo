<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ResettingController extends Controller
{
    public function requestAction(Request $request)
    {
        // TODO
        
        return $this->render('AcmeUserBundle:Resetting:request.html.twig', array(
           
        ));
    }
    
    /**
     * Request reset user password: submit form and send email
     */
    public function sendEmailAction(Request $request)
    {
        
    }
}
