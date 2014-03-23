<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModuleController extends Controller
{
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository('AcmeBoardBundle:Module');
        $modules = $repo->findByEnableIndexing(true);
         
        $params = array('modules' => $modules);
        return $this->render('AcmeBoardBundle:Module:index.html.twig', $params);
    }

}
