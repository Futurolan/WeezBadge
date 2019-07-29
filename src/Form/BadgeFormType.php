<?php


namespace App\Form;

use App\Entity\Badge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BadgeFormType
 * @package App\Form
 */
class BadgeFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [])
            ->add('nom', TextType::class, [])
            ->add('email', EmailType::class, [])
            ->add('societe', TextType::class, [])
            ->add('fonction', TextType::class, [])
            ->add('notify', CheckboxType::class, [])
            ;


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Badge::class,
        ]);
    }


}