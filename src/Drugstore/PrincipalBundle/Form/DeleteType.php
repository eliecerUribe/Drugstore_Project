<?php

namespace Drugstore\PrincipalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DeleteType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id', 'hidden');
		$builder->add('idInventario', 'entity', array(
				'class' => 'Drugstore\\PrincipalBundle\\Entity\\Inventory',
				'property' => 'descripcion',
				'multiple' => false,
		));
		$builder->add('nombreMedicamento');
		$builder->add('causa', 'choice', array(
					'choices' => array('1' => 'Robo', '2' => 'Pérdida', '3' => 'Apropiación Indevida', '4' => 'Destrucción', '5' => 'Deterioro', '6' => 'Otros'),
					'required' => true,
		));
		$builder->add('fecha', 'hidden');
		$builder->add('cantidad');
	}
	
	public function getName()
    {
        return 'delete';
    }
}
