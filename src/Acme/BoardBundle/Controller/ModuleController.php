<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModuleController extends Controller
{
    public function indexAction()
    {
        $modules = $this->getDoctrine()
            ->getRepository('AcmeBoardBundle:Module')
            ->findBy(array('parent' => null));
    
    
        // TODO admin role

        
        $params = array('modules' => $modules);
        return $this->render('AcmeBoardBundle:Module:index.html.twig', $params);
    }

}
