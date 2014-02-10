<?php

namespace Drugstore\PrincipalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Drugstore\PrincipalBundle\Entity\Medicament;
use Drugstore\PrincipalBundle\Entity\Delete;
use Drugstore\PrincipalBundle\Entity\Transfer;

use Drugstore\PrincipalBundle\Form\EnquiryType;
use Drugstore\PrincipalBundle\Form\DeleteType;
use Drugstore\PrincipalBundle\Form\TransferType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicamentController extends Controller
{
	public function addAction()
	{
		$medicamento = new Medicament();
		$form = $this->createForm(new EnquiryType(), $medicamento); /* array('action' => $this->generateUrl('drugstore_medicament_processAdd'), 'method' => 'POST')); */
		
		
		$request = $this->getRequest();
		if ($request->isMethod('POST')) {
			$form->bind($request); // se vinculan los datos al formulario

			if ($form->isValid()) { // pregunta si el objeto $medicamento posee datos validos
				$em = $this->getDoctrine()->getManager();			
				$em->persist($medicamento); // el objeto es guardado para ser insertado
				//$medicamento->getMedicamentXactiveIngredient();
				 
				//$em->flush();  // se ejecuta la insercion a la BD
				//return $this->redirect($this->generateUrl('drugstore_principal_homepage'));
				return $this->render('DrugstorePrincipalBundle:Medicament:showMedicamento.html.twig', array('medicamento' => $medicamento));
			}
		}
		return $this->render('DrugstorePrincipalBundle:Medicament:add.html.twig', array(
			'form' => $form->createView()
		));
	}
	
	public function deleteAction()
	{
		$deletion = new Delete();
		$form = $this->createForm(new DeleteType(), $deletion);
		return $this->render('DrugstorePrincipalBundle:Medicament:delete.html.twig', array(
			'form' => $form->createView()
		));
	}
	
	public function transferAction()
	{
		$transfer = new Transfer();
		$form = $this->createForm(new TransferType(), $transfer);
		return $this->render('DrugstorePrincipalBundle:Medicament:transfer.html.twig', array(
			'form' => $form->createView()
		));
	}
}
