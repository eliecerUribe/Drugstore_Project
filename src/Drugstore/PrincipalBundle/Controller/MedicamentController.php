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
use Symfony\Component\Validator\Constraints\Date;

class MedicamentController extends Controller
{
	public function addAction()
	{
		$medicamento = new Medicament();
		
		$request = $this->getRequest();
		
		$form = $this->createForm(new EnquiryType(), $medicamento); /* array('action' => $this->generateUrl('drugstore_medicament_processAdd'), 'method' => 'POST')); */
		
		if ($request->isMethod('POST')) {
			
			$form->bind($request); 					// se vinculan los datos al formulario
			
			if ($form->isValid()) { 				// pregunta si el objeto $medicamento posee datos validos
				
				$em = $this->getDoctrine()->getManager();			
				
				$em->persist($medicamento); 		// el objeto es guardado para ser insertado
				
				$em->flush();  						// se ejecuta la insercion a la BD
				
				return $this->redirect($this->generateUrl('drugstore_principal_homepage'));
				
				//return $this->render('DrugstorePrincipalBundle:Medicament:showMedicamento.html.twig', array('medicamento' => $medicamento));
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
		
		$request = $this->getRequest();
		
		if ($request->isMethod('POST')) {
		
			$form->bind($request); 					// se vinculan los datos al formulario
			
			if ($form->isValid()) { 				// pregunta si el objeto $medicamento posee datos validos
			
				$em = $this->getDoctrine()->getManager();
				
				$inventario = $form->get('idInventario')->getData();
				
				$nombre_m = $form->get('nombreMedicamento')->getData();
				
				$id_i = ($inventario == 'Individual') ? 1 : 2;
				
				$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findOneBy(
								array('inventario' =>  $id_i,
									  'nombre' => $nombre_m 
								));
				
				if(!$medicamento)
					{
						throw $this->createNotFoundException('Unable to find specified medicament.');
					}
				
				if($id_i == 1)
				{
					$em->remove($medicamento);
					
				}
				else
				{
					$cantidad = $form->get('cantidad')->getData();
					
					$cantidad_m = $medicamento->getCantidad();
					
					$cantidad_m = $cantidad_m - $cantidad;
					
					$medicamento->setCantidad($cantidad_m);
				}
				
				$deletion->setFecha(new \DateTime('now'));
				
				$deletion->setIdInventario($id_i);
				
				$em->persist($deletion);
				
				$em->flush();
				
				return $this->redirect($this->generateUrl('drugstore_principal_homepage'));
			
			}
		
		}
		
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
	
	public function editAction()
	{
		$request = $this->getRequest();
		
		$form = $this->createFormBuilder()
        ->add('idInventario', 'text')
        ->add('nombre', 'text')
        ->getForm();
        
        if($request->isMethod('POST')) {
		
			$form->bind($request);
			
			if ($form->isValid()) {
				
				$em = $this->getDoctrine()->getManager();
				
				$id_i = $form->get('idInventario')->getData();
				
				$nombre_m = $form->get('nombre')->getData();
				
				$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findOneBy(
								array('inventario' =>  $id_i,
									  'nombre' => $nombre_m 
								));
				
				$id = $medicamento->getId();
				
				if(!$medicamento)
				{
					throw $this->createNotFoundException('Unable to find Medicament entity.');
				}

				return $this->redirect($this->generateUrl('drugstore_medicament_update', array(
                    'id' => $id
                )));
			}
		}
				
		return $this->render('DrugstorePrincipalBundle:Medicament:edit.html.twig', array(
			'form' => $form->createView()
		));
	}
	
	public function updateAction($id)
	{
		$request = $this->getRequest();
		
		$em = $this->getDoctrine()->getManager();
		
		$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->find($id);
		
		if(!$medicamento)
		{
			throw $this->createNotFoundException('Unable to find Medicament entity.');
		}
		
		$form = $this->createForm(new EnquiryType(), $medicamento);
		
		if ($request->isMethod('POST')) {
		
			$form->bind($request);
			echo "yo estuve aquí";
			if ($form->isValid()) { 
				
				$em->persist($medicamento);
				
				$em->flush();
				
				return $this->redirect($this->generateUrl('drugstore_principal_homepage'));
			}
		}
		
		return $this->render('DrugstorePrincipalBundle:Medicament:update.html.twig', array(
					'form' => $form->createView(),
				));
	}
}
