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
			
			$form = $this->createForm(new EnquiryType(), $medicamento); 
			
			$em = $this->getDoctrine()->getManager();
					
			$inventarios = $em->getRepository('DrugstorePrincipalBundle:Inventory')->findAll();
					
					
			if ($request->isMethod('POST')) {
				
				$form->bind($request); 					// se vinculan los datos al formulario
				
				if ($form->isValid()) { 				// pregunta si el objeto $medicamento posee datos validos
					
					$numLote = $form->get('numLote')->getData();
					
					$fechaE  = $form->get('fechaEmision')->getData();
					
					$fechaV  = $form->get('fechaVencimiento')->getData();
					
					if($form->get('inventario')->getData() == 'Individual')  //Si es un bien individual no debe rellenar campos en (*)
					{
						if((!empty($numLote))or(!empty($fechaE))or(!empty($fechaV)))
							
							throw $this->createNotFoundException('Campos en (*) son unicamente para bienes masivos.');
						
						$medicamento->setCantidad(1);
					}
					else if(($form->get('inventario')->getData() == 'Masivo'))
					{
						if((empty($numLote))or(empty($fechaE))or(empty($fechaV)))
							
							throw $this->createNotFoundException('Almacenamiento de bien masivo, ingresar campos requiridos (*).');
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
				
				$codigo_m = $form->get('codMedicamento')->getData();
				
				$nombre_m = $form->get('nombreMedicamento')->getData();
				
				//$id_i = ($inventario == 'Individual') ? 1 : 2;
				
				$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findOneBy(
								array('numSerie' =>  $codigo_m,
									  'nombre'   => $nombre_m 
								));
				
				if(!$medicamento)
					{
						throw $this->createNotFoundException('Unable to find specified medicament.');
					}
				
				$cantidad = $form->get('cantidad')->getData();
				
				if($cantidad > $medicamento->getCantidad())
					
					throw $this->createNotFoundException('La cantidad a remover es mayor a la suministrada por el inventario.');
				
				$cantidad_m = $medicamento->getCantidad() - $cantidad;  // Diferencia entre cantidades
				
				$medicamento->setCantidad($cantidad_m); 				// Se ajusta el valor restante luego de baja
				
				
				$deletion->setFecha(new \DateTime('now'));
				
				$deletion->setCodMedicamento($codigo_m);
				
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
		
		$em = $this->getDoctrine()->getManager();
		
		if($request->isMethod('POST')) {
			
			$form->bind($request);
			
			if ($form->isValid()) {
				
				$id_m = $form->get('idMedicamento')->getData();
				
				$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findOneBy(
								array('numSerie' =>  $id_m, 
								));
				
				if(!$medicamento)
				{
						throw $this->createNotFoundException('Unable to find specified medicament.');
				}
				
				if($medicamento->getInventario()->getDescripcion() != 'Masivo')
					
					throw $this->createNotFoundException('El código introducido no está asociado a un bien masivo.');
			
				$cantidad = $form->get('cantidad')->getData();
				
				$u_cedente = $form->get('unidadCedente')->getData();
				
				$u_destino = $form->get('unidadDestino')->getData();
				
				
				if($cantidad <= $medicamento->getNumDosis())   // Si la cantidad a transferir no excede el número de dosis disponibles
				{
					$cantidadRestante = $medicamento->getNumDosis() - $cantidad;
					
					$medicamento->setNumDosis($cantidadRestante);
				}
				else throw $this->createNotFoundException('The amount transferred exceeds the value available.');
				
				$transfer->setIdMedicamento($id_m);
				
				$transfer->setFechaTraspaso(new \DateTime('now'));
				
				$transfer->setNombreMedicamento($medicamento->getNombre());
				
				$em->persist($transfer); 
					
				$em->flush(); 
					
				return $this->redirect($this->generateUrl('drugstore_principal_homepage'));
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
			->add('idMedicamento')
			->add('nombre', 'text')
			->getForm();
			
			if($request->isMethod('POST')) {
			
				$form->bind($request);
				
				if ($form->isValid()) {
					
					$em = $this->getDoctrine()->getManager();
					
					$id_m = $form->get('idMedicamento')->getData();
					
					$nombre_m = $form->get('nombre')->getData();
					
					$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findOneBy(
									array('numSerie' =>  $id_m,
										  'nombre'   => $nombre_m 
									));
					
					if(!$medicamento)
					{
						throw $this->createNotFoundException('Unable to find specified medicament.');
					}
					$id = $medicamento->getId();
					
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
        ->add('idMedicamento')
        ->add('nombre', 'text')
        ->getForm();
        
        if($request->isMethod('POST')) {
		
			$form->bind($request);
			
			if ($form->isValid()) {
				
				$em = $this->getDoctrine()->getManager();
				
				$id_m = $form->get('idMedicamento')->getData();
				
				$nombre_m = $form->get('nombre')->getData();
				
				$medicamento = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findOneBy(
								array('numSerie' =>  $id_m,
									  'nombre'   => $nombre_m 
								));
				
				if(!$medicamento)
				{
					throw $this->createNotFoundException('Unable to find Medicament entity.');
				}
				
				$id = $medicamento->getId();

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
			
			$url1 = $this->generateUrl('drugstore_principal_homepage');
			
			if ($request->isMethod('POST')) {
				
				$form->bind($request); 
				
				if ($form->isValid()) {
					
					$url1 = $this->generateUrl('drugstore_medicament_reports');
					
					$url2 = $this->generateUrl('drugstore_medicament_save');
						
					if($form->get('select1')->getData()) {
						
						$medicamentos = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findAll();
					}
					else{
						
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
							'url1'		   => $url1,
							'url2'		   => $url2,
						));
				}
			}
			return $this->render('DrugstorePrincipalBundle:Medicament:reports.html.twig', array(
				'form' => $form->createView(),
				'url'  => $url1,
			));
		}
	}
	
	public function saveAction()
	{
		$request = $this->getRequest();
			
		$em = $this->getDoctrine()->getManager();
		
		$medicamentos = $em->getRepository('DrugstorePrincipalBundle:Medicament')->findAll();
		
		$vacio = FALSE;
		
		$html = $this->renderView('DrugstorePrincipalBundle:Medicament:showReports.html.twig', array(
							'medicamentos' => $medicamentos,
							'vacio'		   => $vacio,
							'url1'		   => '#',
							'url2'		   => '#',
		));


		return new Response(
			$this->get('knp_snappy.pdf')->getOutputFromHtml($html),
			200,
			array(
				'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
			)
		);
	}
}
