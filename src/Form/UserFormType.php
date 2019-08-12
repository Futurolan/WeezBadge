<?php


namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserFormType
 * @package App\Form
 */
class UserFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom",
                'help' => "Le nom de l'utilisateur sera mis à jour depuis son compte Google à la première connexion.",
            ])
            ->add('email', EmailType::class, [
                'help' => "L'adresse email doit correspondre à l'adresse principale du compte FuturoLAN/ESL/Google.",
            ])
            ->add('roles', ChoiceType::class, [
                'label' => "Rôle",
                'expanded' => true,
                'multiple' => true,
                'choices' => [array_flip(User::ROLE_MAPPING)],
                'help' => "Un Super Admin peut gérer les utilisateurs et définir l'événement par défaut, un Admin peut accéder à toutes les catégories de badges de l'événement par défaut, un User ne peut accéder qu'à des catégories définies par un Super Admin.",
            ])
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}