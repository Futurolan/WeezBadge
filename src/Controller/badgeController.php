<?php


namespace App\Controller;

use App\Form\BadgeFormType;
use Futurolan\WeezeventBundle\Client\WeezeventClient;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class createBadgeController
 * @package App\Controller
 */
class badgeController extends AbstractController
{

    /** @var SerializerInterface */
    private $serializer;

    /** @var WeezeventClient */
    private $weezeventClient;

    /**
     * createBadgeController constructor.
     * @param SerializerInterface $serializer
     * @param WeezeventClient $weezeventClient
     */
    public function __construct(SerializerInterface $serializer, WeezeventClient $weezeventClient)
    {
        $this->serializer = $serializer;
        $this->weezeventClient = $weezeventClient;
    }


    /**
     * @Route("/event/{eventID}/ticket/{ticketID}/delete/{participantID}", name="deleteParticipant")
     * @param string $eventID
     * @param string $ticketID
     * @param string $participantID
     * @return Response
     * @throws GuzzleException
     */
    public function deleteParticipant(string $eventID, string $ticketID, string $participantID)
    {
        $this->weezeventClient->deleteParticipant($eventID, $participantID);
        return $this->redirectToRoute('eventParticipantsByTicketPage', ['eventID' => $eventID, 'ticketID' => $ticketID]);
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