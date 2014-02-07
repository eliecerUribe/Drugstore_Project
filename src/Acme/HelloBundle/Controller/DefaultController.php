<?php

/*namespace Acme\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
		return $this->render('AcmeHelloBundle:Default:index.html.twig', array('name' => $name));
    }
}
*/


namespace Acme\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return new Response('<html><h1>Hello '.$name.'!</h1></html>');
    }
}
