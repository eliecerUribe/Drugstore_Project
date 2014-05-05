<?php

namespace Drugstore\PrincipalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Drugstore\PrincipalBundle\Entity\Medicament;
use Drugstore\PrincipalBundle\Entity\Delete;
use Drugstore\PrincipalBundle\Entity\Transfer;
use Drugstore\PrincipalBundle\Entity\Inventory;

use Drugstore\PrincipalBundle\Form\EnquiryType;
use Drugstore\PrincipalBundle\Form\DeleteType;
use Drugstore\PrincipalBundle\Form\TransferType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MedicamentController extends Controller
{
	public function addAction()
	{
		if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          
          throw new AccessDeniedException();
		}
		else {
			$medicamento = new Medicament();
			
			$request = $this->getRequest();
			
			$form = $this->createForm(new EnquiryType(), $medicamento); /* array('action' => $this->generateUrl('drugstore_medicament_processAdd'), 'method' => 'POST')); */
			
			$em = $this->getDoctrine()->getManager();
					
			$inventarios = $em->getRepository('DrugstorePrincipalBundle:Inventory')->findAll();
					
					
			if ($request->isMethod('POST')) {
				
				$form->bind($request); 					// se vinculan los datos al formulario
				
				if ($form->isValid()) { 				// pregunta si el objeto $medicamento posee datos validos
					
					
					//$var = $form->get('inventario')->getData();
					
					$em = $this->getDoctrine()->getManager();
					
					$em->persist($medicamento); 		// el objeto es guardado para ser insertado
					
					$em->flush(); 
					
					return $this->redirect($this->generateUrl('drugstore_principal_homepage'));
					
				}
			}
			return $this->render('DrugstorePrincipalBundle:Medicament:add.html.twig', array(
				'form' => $form->createView(),
				'inventarios' => $inventarios,
			));
		}
	}
	
	public function deleteAction()
	{
		$deletion = new Delete();
		
		$form = $this->createForm(new DeleteType(), $deletion);
		
		$request = $this->getRequest();
		
		if ($request->isMethod('POST')) {
		
			$form->bind($request);
			
			if ($form->isValid()) {
			
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
		if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          
          throw new AccessDeniedException();
		}
		else {
			$request = $this->getRequest();
			
			$form = $this->createFormBuilder()
			->add('idInventario', 'entity', array(
					'class' => 'Drugstore\\PrincipalBundle\\Entity\\Inventory',
					'property' => 'descripcion',
					'multiple' => false,
			))
			->add('nombre', 'text')
			->getForm();
			
			if($request->isMethod('POST')) {
			
				$form->bind($request);
				
				if ($form->isValid()) {
					
					$em = $this->getDoctrine()->getManager();
					
					$inventario = $form->get('idInventario')->getData();
					
					$id_i = ($inventario == 'Individual') ? 1 : 2;
					
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
	}
	
	public function updateAction($id)
	{
		if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          
          throw new AccessDeniedException();
		}
		else {
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

				if ($form->isValid()) { 
					
					$em->persist($medicamento);
					
					$em->flush();
					
					return $this->redirect($this->generateUrl('drugstore_principal_homepage'));
				}
			}
			return $this->render('DrugstorePrincipalBundle:Medicament:add.html.twig', array(
						'form' => $form->createView(),
					));
		}
	}
	
	public function setupStockAction()
	{
		$request = $this->getRequest();
		
		$form = $this->createFormBuilder()
        ->add('idInventario', 'entity', array(
				'class' => 'Drugstore\\PrincipalBundle\\Entity\\Inventory',
				'property' => 'descripcion',
				'multiple' => false,
		))
        ->add('nombre', 'text')
        ->getForm();
        
        if($request->isMethod('POST')) {
		
			$form->bind($request);
			
			if ($form->isValid()) {
				
				$em = $this->getDoctrine()->getManager();
				
				$inventario = $form->get('idInventario')->getData();
				
				$id_i = ($inventario == 'Individual') ? 1 : 2;
				
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

				return $this->redirect($this->generateUrl('drugstore_medicament_stock', array(
                    'id' => $id
                )));
			}
		}
				
		return $this->render('DrugstorePrincipalBundle:Medicament:edit.html.twig', array(
			'form' => $form->createView()
		));
	}
	
	public function stockAction($id)
	{
		$request = $this->getRequest();
		
		/*$form = $this->createFormBuilder()
        ->add('stockMaximoActual', 'text')
        ->add('stockMinimoActual', 'text')
        ->getForm();*/
		
		$em = $this->getDoctrine()->getManager();
		
		$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->find($id);
		
		if(!$medicamento)
		{
			throw $this->createNotFoundException('Unable to find Medicament entity.');
		}
		$nombre = $medicamento->getNombre();
		
		$stock_max = $medicamento->getStockMaximo();
		
		$stock_min = $medicamento->getStockMinimo();
		
		$cantidad_m = $medicamento->getCantidad();
		
		if(($cantidad_m < ($stock_min + floor(($stock_max-$stock_min)/2))) and ($cantidad_m > $stock_min))
		{
			$valor = '75%';
			$color = 'purple';
			$mensaje = 'Por encima de stock min.';
		}
		else if(($cantidad_m <= $stock_min) and ($cantidad_m >= floor($stock_min/2)))
		{
			$valor = '25%';
			$color = 'yellow';
			$mensaje = 'Por debajo de stock min.';
		}
		else if($cantidad_m > ($stock_min + floor(($stock_max-$stock_min)/2)))
		{
			$valor = '98%';
			$color = 'green';
			$mensaje = 'Esta en el tope.';
		}
		else 
		{ 
			$valor = '5%';
			$color = 'red';
			$mensaje = '¡Alerta! Tomar medidas.';
		}
		
		$url = $this->generateUrl(
            'drugstore_medicament_edit_stock',
            array('id' => $id)
        );
		
		//if ($request->isMethod('POST')) {
		
			//$form->bind($request);

			//if ($form->isValid()) { 
				
				//return $this->redirect($this->generateUrl('drugstore_principal_homepage'));
			//}
		//}
		return $this->render('DrugstorePrincipalBundle:Medicament:stock.html.twig', array(
					'nombre' => $nombre,
					'stock_max' => $stock_max,
					'stock_min' => $stock_min,
					'valor' => $valor,
					'color' => $color,
					'mensaje' => $mensaje,
					'cantidad' => $cantidad_m,
					'url' => $url,
					//'form' => $form->createView()
				));
	}
	
	public function editStockAction($id)
	{
		$request = $this->getRequest();
		
		$em = $this->getDoctrine()->getManager();
		
		$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->find($id);
		
		$nombre = $medicamento->getNombre();
		
		if(!$medicamento)
		{
			throw $this->createNotFoundException('Unable to find Medicament entity.');
		}
		
		$form = $this->createFormBuilder($medicamento)
        ->add('stockMaximo', 'text')
        ->add('stockMinimo', 'text')
        ->add('cantidad', 'text')
        ->getForm();
        
        $url = $this->generateUrl(
            'drugstore_medicament_stock',
            array('id' => $id)
        );
        
        if ($request->isMethod('POST')) {
		
			$form->bind($request);

			if ($form->isValid()) { 
				
				$em->persist($medicamento);
				
				$em->flush();
				
				return $this->redirect($this->generateUrl('drugstore_medicament_stock',	array('id' => $id)));
			}
		}
        
        return $this->render('DrugstorePrincipalBundle:Medicament:editStock.html.twig', array(
			'nombre' => $nombre,
			'url' => $url,
			'form' => $form->createView()
		));
	}
	
	public function reportsAction()
	{   
		if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          
          throw new AccessDeniedException();
		}
		else {	
			$request = $this->getRequest();
			
			$em = $this->getDoctrine()->getManager();
			
			$form = $this->createFormBuilder()
			->add('select1', 'checkbox')		//Todos.
			->add('select2', 'checkbox')		//Agotados.
			->add('select3', 'checkbox')		//Llegaron a stock minimo.
			->add('texto2', 'text')				//Nombre.
			->add('texto3', 'text')				//laboratorio.
			->add('texto4', 'text')				//Principio(s) activo(s).
			->add('texto5', 'text')				//Tipo de Presentación.
			->add('texto6', 'text')				//Lote.
			->add('texto7', 'date', array(
					'widget' => 'single_text',
					))							//Fecha Emisión.
			->add('texto8', 'date', array(
					'widget' => 'single_text',
					))							//Fecha Vencimiento.
			->getForm();
			
			if ($request->isMethod('POST')) {
				
				$form->bind($request); 
				
				if ($form->isValid()) {
					
					$agotados = ($form->get('select2')->getData()) ? 1 : 0;
						
					$llegaronSM = ($form->get('select3')->getData()) ? 1 : 0;
						
					if($form->get('select1')->getData()) {
						
						$medicamentos = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findAll();
					}
					else{
					
						$nombre = $form->get('texto2')->getData();
						
						if(empty($nombre)) $nombre = '';
						
						$laboratorio = $form->get('texto3')->getData();
						
						if(empty($laboratorio)) $laboratorio = '';
						
						$pa = $form->get('texto4')->getData();
						
						if(empty($pa)) $pa = '';
						
						$presentacion = $form->get('texto5')->getData();
						
						if(empty($presentacion)) $presentacion = '';
						
						$lote = $form->get('texto6')->getData();
						
						if(empty($lote)) $lote = '';
						
						$fechaEmision = $form->get('texto7')->getData();
						
						if(empty($fechaEmision)) $fechaEmision = '';
						
						$fechaVencimiento = $form->get('texto8')->getData();
						
						if(empty($fechaVencimiento)) $fechaVencimiento = '';
						
						$qb = $em->createQueryBuilder();
						
						$qb->add('select', 'a')
						   ->add('from', 'DrugstorePrincipalBundle:Medicament a')
						   ->add('where', "(a.nombre = ?2 or ?2 = '') and
										   (a.laboratorio = ?3 or ?3 = '')  and
										   (a.tipoPresentacion = ?5 or ?5 = '') and
										   (a.numLote = ?6 or ?6 = '') and
										   (a.fechaEmision = ?7 or ?7 = '') and
										   (a.fechaVencimiento = ?8 or ?8 = '') and
										   (a.cantidad = 0 or ?9 = 0) and
										   (a.cantidad <= a.stockMinimo or ?10 = 0) "
								)
						   ->setParameter('2', $nombre)
						   ->setParameter('3', $laboratorio)
						   ->setParameter('5', $presentacion)
						   ->setParameter('6', $lote)
						   ->setParameter('7', $fechaEmision)
						   ->setParameter('8', $fechaVencimiento)
						   ->setParameter('9', $agotados)
						   ->setParameter('10', $llegaronSM);
						
						$query = $qb->getQuery();
							  
						$medicamentos = $query->getResult();
					}
					
					return $this->render('DrugstorePrincipalBundle:Medicament:showReports.html.twig', array(
						'medicamentos' => $medicamentos,
					));
				}
			}
			return $this->render('DrugstorePrincipalBundle:Medicament:reports.html.twig', array(
				'form' => $form->createView(),
			));
		}
	}
}
