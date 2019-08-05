<?php


namespace App\Form;

use App\Controller\BadgeController;
use App\Entity\Import;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ImportFormType
 * @package App\Form
 */
class ImportFormType extends AbstractType
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
            ->add('csv', TextareaType::class, [
                'label' => "CSV",
                'help' => "Obligatoire",
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
            'data_class' => Import::class,
        ]);
    }
}