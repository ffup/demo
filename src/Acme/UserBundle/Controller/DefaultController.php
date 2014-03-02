<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $name = null;
        return $this->render('AcmeUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
