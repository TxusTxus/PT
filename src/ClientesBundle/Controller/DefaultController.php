<?php

namespace ClientesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientesBundle:Default:index.html.twig');
    }
}
