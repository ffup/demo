<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends Controller
{
    public function indexAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted(
            'IS_AUTHENTICATED_FULLY'
           )) {
            throw new AccessDeniedException();
        }
        
        return $this->render('AcmeUserBundle:Profile:index.html.twig', array());
    }
}
