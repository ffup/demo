<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModuleController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AcmeBoardBundle:Module');
        
        $modules = $repo->findAllModules();
         
        $params = array('modules' => $modules);
        return $this->render('AcmeBoardBundle:Module:index.html.twig', $params);
    }
}
