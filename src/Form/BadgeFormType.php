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
            ->add('prenom', TextType::class, [
                'label' => "Prénom",
            ])
            ->add('nom', TextType::class, [])
            ->add('pseudo', TextType::class, [])
            ->add('email', EmailType::class, [
                'label' => "Adresse email",
                'help' => "Obligatoire, le badge sera envoyé à cette adresse.",
            ])
            ->add('societe', TextType::class, [
                'label' => "Société",
            ])
            ->add('fonction', TextType::class, [])
            ->add('notify', CheckboxType::class, [
                'label' => "Notification",
                'help' => "Un email sera automatiquement envoyé par Weezevent à l'adresse email si la notification est activée.",
                'data' => true,
            ])
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