<?php

namespace ComunicacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ComunicacionBundle:Default:index.html.twig');
    }
}
