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
		$builder->add('PrincipiosActivos', 'entity', array(
				'class' => 'Drugstore\\PrincipalBundle\\Entity\\ActiveIngredient',
				'property' => 'nombre',
				'empty_value' => '--Seleccione--',
				'multiple' => true,
		));
		$builder->add('precioUnitario');
		$builder->add('numDosis');
		$builder->add('laboratorio');
		$builder->add('numLote');
		$builder->add('fechaEmision','date', array(
				'widget' => 'single_text',
				));
		$builder->add('fechaVencimiento','date', array(
				'widget' => 'single_text',
				));
		$builder->add('tipoPresentacion');
		$builder->add('inventario', 'entity', array(
				'class' => 'Drugstore\\PrincipalBundle\\Entity\\Inventory',
				'property' => 'descripcion',
				'multiple' => false,
				'empty_value' => '--Seleccione--',
		));
		$builder->add('cantidad');
		$builder->add('stockMaximo');
		$builder->add('stockMinimo');
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
