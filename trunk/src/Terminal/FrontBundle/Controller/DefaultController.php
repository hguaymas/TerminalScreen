<?php

namespace Terminal\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {               
        return $this->render('TerminalFrontBundle:Default:index.html.twig');
    }
}
