<?php


namespace App\Form;

use App\Controller\BadgeController;
use App\Entity\Acl;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserAclFormType
 * @package App\Form
 */
class UserAclFormType extends AbstractType
{
    /** @var BadgeController */
    private $badgeController;

    /**
     * UserAclFormType constructor.
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
            ->add('allowedTickets', ChoiceType::class, [
                'label' => "Accès aux badges :",
                'expanded' => true,
                'multiple' => true,
                'choices' => $this->badgeController->getTicketsForm(),
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Acl::class,
        ]);
    }
}