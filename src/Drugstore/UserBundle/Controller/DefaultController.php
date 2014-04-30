<?php

namespace Drugstore\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DrugstoreUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
