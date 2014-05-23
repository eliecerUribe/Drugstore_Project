<?php

namespace Drugstore\PrincipalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Drugstore\PrincipalBundle\Entity\Medicament;
use Drugstore\PrincipalBundle\Entity\Delete;
use Drugstore\PrincipalBundle\Entity\Transfer;
use Drugstore\PrincipalBundle\Entity\Inventory;
use Drugstore\PrincipalBundle\Entity\ActiveIngredient;

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
					
					
					if($form->get('inventario')->getData() == 'Individual')
					{
						$medicamento->setCantidad(1);
					}
					
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
		$request = $this->getRequest();
		
		$transfer = new Transfer();
		
		$form = $this->createForm(new TransferType(), $transfer);
		
		if($request->isMethod('POST')) {
			
			$form->bind($request);
			
			if ($form->isValid()) {
				
				$id_i = $form->get('idInventario')->getData();
				
				$nombre_m = $form->get('nombreMedicamento')->getData();
				
				$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findOneBy(
								array('inventario' =>  $id_i,
									  'nombre' => $nombre_m 
								));
				
				if(!$medicamento)
				{
						throw $this->createNotFoundException('Unable to find specified medicament.');
				}
				else
				{
					$cantidad = $form->get('cantidad')->getData();
					
					$u_cedente = $form->get('unidadCedente')->getData();
					
					$u_destino = $form->get('unidadDestino')->getData();
					
					//if($medicamento->getCantidad() >= )
					
					//$observaciones = $form->get('observaciones')->getData();
					
					//$transfer->setFechaTraspaso(new \DateTime('now'));
				}
			
			}
		}
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
			->add('texto4', 'entity', array(
				'class' => 'Drugstore\\PrincipalBundle\\Entity\\ActiveIngredient',
				'property' => 'nombre',
				'multiple' => true,
			))				//Principio(s) activo(s).
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
					
					$url = $this->generateUrl('drugstore_medicament_reports');
						
					if($form->get('select1')->getData()) {
						
						$medicamentos = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findAll();
					}
					else{
						
						//$requestAll = $this->getRequest()->request->all();
						
						//$pa = $requestAll['form']['texto4']; 				//retrieve indexed array
						//foreach ($pa as $i) {
							//	$arreglo[] = $i;
							//}
						
						$pa = $this->getRequest()->request->get('form[texto4]', null, true);
					
						$qb = $em->createQueryBuilder();
							
						$qb->add('select', 'a')
						   ->add('from', 'DrugstorePrincipalBundle:Medicament a')
						   ->innerJoin('a.mpa', 'p');
					
						if(!empty($pa))
						{
							$qb->andWhere('p.principioActivo in (:arreglo)')
							   ->setParameter('arreglo', $pa);
						}
						if($form->get('texto2')->getData())
						{
							$nombre = $form->get('texto2')->getData();
							$qb->andWhere('a.nombre = ?2')
							   ->setParameter('2', $nombre);
						}
						if($form->get('texto3')->getData())
						{
							$laboratorio = $form->get('texto3')->getData();
							$qb->andWhere('a.laboratorio = ?3')
							   ->setParameter('3', $laboratorio);
						}
						if($form->get('texto5')->getData())
						{
							$presentacion = $form->get('texto5')->getData();
							$qb->andWhere('a.tipoPresentacion = ?5')
							   ->setParameter('5', $presentacion);
						}
						if($form->get('texto6')->getData())
						{
							$lote = $form->get('texto6')->getData();
							$qb->andWhere('a.numLote = ?6')
							   ->setParameter('6', $lote);
						}
						if($form->get('texto7')->getData())
						{
							$fechaEmision = $form->get('texto7')->getData();
							$qb->andWhere('a.fechaEmision = ?7')
							   ->setParameter('7', $fechaEmision);
						}
						if($form->get('texto8')->getData())
						{
							$fechaVencimiento = $form->get('texto8')->getData();
							$qb->andWhere('a.fechaVencimiento = ?8')
							   ->setParameter('7', $fechaVencimiento);
						}
						if($form->get('select2')->getData())
						{
							$qb->andWhere('a.cantidad = 0');
						}
						if($form->get('select3')->getData())
						{
							$qb->andWhere('a.cantidad <= a.stockMinimo');
						}
						
						$qb->orderBy('a.laboratorio', 'ASC');
						
						$query = $qb->getQuery();
							  
						$medicamentos = $query->getResult();					
					}
					if(empty($medicamentos)) 
							$vacio = TRUE;
						else
							$vacio = FALSE;
					
					return $this->render('DrugstorePrincipalBundle:Medicament:showReports.html.twig', array(
							'medicamentos' => $medicamentos,
							'vacio'		   => $vacio,
							'url'		   => $url,
						));
				}
			}
			return $this->render('DrugstorePrincipalBundle:Medicament:reports.html.twig', array(
				'form' => $form->createView(),
			));
		}
	}
}
