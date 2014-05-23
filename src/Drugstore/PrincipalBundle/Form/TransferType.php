<?php

namespace Drugstore\PrincipalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TransferType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id', 'hidden');
		$builder->add('idInventario', 'entity', array(
				'class' => 'Drugstore\\PrincipalBundle\\Entity\\Inventory',
				'property' => 'id',
				'multiple' => false,
				'empty_value' => '--Seleccione--',
		));
		$builder->add('nombreMedicamento');
		$builder->add('cantidad');
		$builder->add('unidadCedente', 'choice', array(
				'choices' => array(
					'1'   => 'Inventario Principal',
					'2'   => 'Inventario Unidosis',
					'3'   => 'Venta al Público',
				),
				'multiple' => false,
		));
		$builder->add('unidadDestino', 'choice', array(
				'choices' => array(
					'1'   => 'Inventario Principal',
					'2'   => 'Inventario Unidosis',
					'3'   => 'Venta al Público',
				),
				'multiple' => false,
		));
		//$builder->add('fechaTraspaso');
		$builder->add('observaciones');
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Drugstore\PrincipalBundle\Entity\Transfer',
        ));
    }

	
	public function getName()
    {
        return 'transfer';
    }
}
