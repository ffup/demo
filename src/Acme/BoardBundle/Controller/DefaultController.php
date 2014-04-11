<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $response = $this->render('AcmeBoardBundle:Default:index.html.twig', array());
            // set the shared max age - which also marks the response as public
        $response->setSharedMaxAge(600);

        return $response;
    }
}
