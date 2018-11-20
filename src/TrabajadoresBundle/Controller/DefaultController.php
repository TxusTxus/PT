<?php

namespace TrabajadoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TrabajadoresBundle:Default:index.html.twig');
    }
}
