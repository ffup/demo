<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    public function indexAction(Request $request)
    {

        return $this->render('AcmeUserBundle:Profile:index.html.twig', array());
    }
}
