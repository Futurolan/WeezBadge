<?php


namespace App\Controller;

use App\Form\BadgeFormType;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class createBadgeController
 * @package App\Controller
 */
class createBadgeController extends AbstractController
{

    /** @var SerializerInterface */
    private $serializer;

    /**
     * createBadgeController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/badge/new", name="newBadgePage")
     * @param Request $request
     * @return Response
     */
    public function createBadge(Request $request)
    {
        $form = $this->createForm(BadgeFormType::class);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            $badge = $form->getData();
            dump($this->serializer->serialize($badge, 'json'));
            dd($badge);
        }

        return $this->render('badge/badgeForm.html.twig', [
            'badgeForm' => $form->createView(),
        ]);
    }
}