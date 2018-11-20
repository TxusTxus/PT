<?php

namespace PartesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PartesBundle:Default:index.html.twig');
    }
}
