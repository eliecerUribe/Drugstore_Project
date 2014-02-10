<?php

namespace Drugstore\PrincipalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EnquiryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('numSerie');
		$builder->add('nombre');
		$builder->add('principiosActivos', 'entity', array(
				'class' => 'Drugstore\\PrincipalBundle\\Entity\\ActiveIngredient',
				'property' => 'nombre',
				'empty_value' => '--Seleccione--',
				'multiple' => true,
		));
		$builder->add('miligramos');
		$builder->add('precioUnitario');
		$builder->add('numDosis');
		$builder->add('laboratorio');
		$builder->add('numLote');
		$builder->add('fechaEmision');
		$builder->add('fechaVencimiento');
		$builder->add('tipoPresentacion');
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Drugstore\PrincipalBundle\Entity\Medicament',
			'cascade_validation' => true,
		));
	}
	
	public function getDefaultOptions(array $options)
	{          return array(
				'data_class' => 'Drugstore\PrincipalBundle\Entity\Medicament',
				);      
	}
	
	public function getName()
    {
        return 'medicament';
    }
}
