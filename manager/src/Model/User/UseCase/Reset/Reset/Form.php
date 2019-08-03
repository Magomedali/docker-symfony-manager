<?php
declare(strict_types=1);

namespace App\Model\User\UseCase\Reset\Reset;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class Form extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
				->add("password", Type\PasswordType::class);
	}


	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class'=>Command::class
		]);
	}
}