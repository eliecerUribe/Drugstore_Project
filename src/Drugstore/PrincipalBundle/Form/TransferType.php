<?php

namespace Drugstore\PrincipalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TransferType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id', 'hidden');
		$builder->add('idInventario', 'choice', array(
					'choices'  => array('individual' => '1', 'masivo' => '2'),
					'required' => false,
		));
		$builder->add('nombreMedicamento');
		$builder->add('cantidad');
		$builder->add('unidadCedente');
		$builder->add('unidadDestino');
		$builder->add('fechaTraspaso');
		$builder->add('observaciones');
	}
	
	public function getName()
    {
        return 'transfer';
    }
}
