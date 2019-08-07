<?php


namespace App\Form;

use App\Controller\BadgeController;
use App\Entity\Badge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

    /** @var BadgeController */
    private $badgeController;

    /**
     * createBadgeController constructor.
     * @param BadgeController $badgeController
     */
    public function __construct(BadgeController $badgeController)
    {
        $this->badgeController = $badgeController;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventID', ChoiceType::class, [
                'label' => "Événement",
                'choices' => $this->badgeController->getAllowedEvent(),
            ])
            ->add('ticketID', ChoiceType::class, [
                'label' => "Catégorie de badge",
                'choices' => $this->badgeController->getAllowedTickets(),
                'help' => "Obligatoire, détermine le niveau d'accès",
            ])
            ->add('prenom', TextType::class, [
                'label' => "Prénom",
                'help' => "Obligatoire",
            ])
            ->add('nom', TextType::class, [
                'label' => "Nom",
                'help' => "Obligatoire",
            ])
            ->add('pseudo', TextType::class, [
                'label' => "Pseudonyme",
                'help' => "Optionnel",
            ])
            ->add('email', EmailType::class, [
                'label' => "Adresse email",
                'help' => "Obligatoire, le badge sera envoyé à cette adresse",
            ])
            ->add('societe', TextType::class, [
                'label' => "Société",
                'help' => "Optionnel, mais recommandé",
            ])
            ->add('fonction', TextType::class, [
                'help' => "Optionnel",
            ])
            ->add('notify', CheckboxType::class, [
                'label' => "Notification",
                'help' => "Envoi automatique par Weezevent d'un email contenant le billet à l'adresse email du destinataire",
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