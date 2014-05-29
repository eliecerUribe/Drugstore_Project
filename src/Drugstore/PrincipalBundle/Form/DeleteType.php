<?php

namespace Drugstore\PrincipalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DeleteType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id', 'hidden');
		$builder->add('codMedicamento');
		$builder->add('nombreMedicamento');
		$builder->add('causa', 'choice', array(
					'choices' => array('robo' => 'Robo', 'perdida' => 'Pérdida', 'apropiacion indebida' => 'Apropiación Indevida', 'destruccion' => 'Destrucción', 'deterioro' => 'Deterioro', 'otros' => 'Otros'),
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
