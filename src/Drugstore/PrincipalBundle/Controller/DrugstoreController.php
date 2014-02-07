<?php

namespace Drugstore\PrincipalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DrugstoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('DrugstorePrincipalBundle:Drugstore:index.html.twig');
    }
	
}
