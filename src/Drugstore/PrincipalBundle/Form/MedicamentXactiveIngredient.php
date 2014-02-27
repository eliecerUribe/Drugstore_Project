<?php

namespace Drugstore\PrincipalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MedicamentXactiveIngredientType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id','hidden');
		$builder->add('medicamento');
		$builder->add('principioActivo');
	}
	
	public function getName()
    {
        return 'medicamentXactiveIngredient';
    }
}
