<?php

namespace Drugstore\PrincipalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EnquiryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('numSerie');
		$builder->add('nombre');
		$builder->add('precioUnitario');
		$builder->add('numDosis');
		$builder->add('laboratorio');
		$builder->add('numLote');
		$builder->add('fechaEmision');
		$builder->add('fechaVencimiento');
		$builder->add('principiosActivos','hidden');
		$builder->add('tipoPresentacion');
		$builder->add('stockMaximo');
		$builder->add('stockMinimo');
	}
	
	public function getName()
    {
        return 'medicament';
    }
}
