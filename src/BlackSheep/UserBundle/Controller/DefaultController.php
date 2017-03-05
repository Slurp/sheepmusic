<?php

namespace BlackSheep\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BlackSheepUserBundle:Default:index.html.twig');
    }
}
