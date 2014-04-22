<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function indexAction()
    {
        // TODO
        $params = array();
        return $this->render('AcmeBoardBundle:Search:index.html.twig', $params);
    }
}
