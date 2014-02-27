<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
           
        $user = $this->getUser();
        var_dump($user);
        $name = 123;
        return $this->render('AcmeUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
