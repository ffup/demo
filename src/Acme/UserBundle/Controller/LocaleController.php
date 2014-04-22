<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocaleController extends Controller
{
    public function changeAction()
    {
        return $this->render('AcmeUserBundle:Locale:change.html.twig', array());  
    }
}
