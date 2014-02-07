<?php

namespace Drugstore\PrincipalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DeleteType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id', 'hidden');
		$builder->add('idInventario', 'choice', array(
					'choices'  => array('individual' => '1', 'masivo' => '2'),
					'required' => false,
		));
		$builder->add('nombreMedicamento');
		$builder->add('causa', 'choice', array(
					'choices' => array('1' => 'Robo', '2' => 'Pérdida', '3' => 'Apropiación Indevida', '4' => 'Destrucción', '5' => 'Deterioro', '6' => 'Otros'),
					'required' => false,
		));
		$builder->add('fecha');
		$builder->add('cantidad');
	}
	
	public function getName()
    {
        return 'delete';
    }
}
