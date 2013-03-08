<?php

namespace Galvani\CoffeeClosureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CoffeeClosureBundle:Default:index.html.twig', array('name' => $name));
    }
}
