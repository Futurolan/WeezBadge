<?php


namespace App\Controller;

use App\Entity\Badge;
use App\Form\BadgeFormType;
use App\Form\ImportFormType;
use App\Service\ParameterService;
use Futurolan\WeezeventBundle\Client\WeezeventClient;
use Futurolan\WeezeventBundle\Entity\ParticipantForm;
use Futurolan\WeezeventBundle\Entity\ParticipantPost;
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
class BadgeController extends AbstractController
{

    /** @var SerializerInterface */
    private $serializer;

    /** @var WeezeventClient */
    private $weezeventClient;

    /** @var ParameterService */
    private $parameterService;

    /**
     * createBadgeController constructor.
     * @param SerializerInterface $serializer
     * @param WeezeventClient $weezeventClient
     * @param ParameterService $parameterService
     */
    public function __construct(SerializerInterface $serializer, WeezeventClient $weezeventClient, ParameterService $parameterService)
    {
        $this->serializer = $serializer;
        $this->weezeventClient = $weezeventClient;
        $this->parameterService = $parameterService;
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
        $this->addFlash('success', "Badge supprimé avec succès !");
        return $this->redirectToRoute('eventParticipantsByTicketPage', ['eventID' => $eventID, 'ticketID' => $ticketID]);
    }

    /**
     * @Route("/badge/new", name="newBadgePage")
     * @param Request $request
     * @return Response
     */
    public function createBadge(Request $request)
    {
        $form = $this->createForm(BadgeFormType::class, null, []);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            /** @var Badge $badge */
            $badge = $form->getData();
            $this->weezeventClient->addParticipant($this->badge2ParticipantForm($badge));

            $this->addFlash('success', "Badge créé avec succès !");
            return $this->redirectToRoute('eventParticipantsByTicketPage', ['eventID' => $badge->getEventID(), 'ticketID' => $badge->getTicketID()]);
        }

        return $this->render('badge/badgeForm.html.twig', [
            'badgeForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/badge/import", name="importBadgesPage")
     * @param Request $request
     * @return Response
     */
    public function importBadge(Request $request)
    {
        $form = $this->createForm(ImportFormType::class, null, []);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            /** @var Badge $badge */
            $import = $form->getData();
            dd($import);
        }

        return $this->render('badge/badgeImport.html.twig', [
            'importForm' => $form->createView(),
        ]);
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function getAllowedEvent()
    {
        $res = [];
        $events = $this->weezeventClient->getEvents(false);
        $defaultCategory = $this->parameterService->get($this->parameterService::DEFAULT_CATEGORY_NAME);
        foreach ($events as $event) {
            if ( (int)$defaultCategory['eventID'] === $event->getId() )
            $res[ucwords(strtolower($event->getName()))] = (int)$event->getId();
        }
        return $res;
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function getAllowedTickets()
    {
        $res = ['' => ''];
        $defaultCategory = $this->parameterService->get($this->parameterService::DEFAULT_CATEGORY_NAME);
        if ( empty($defaultCategory['eventID']) || empty($defaultCategory['eventID']) ) { return $res; }
        $tickets = $this->weezeventClient->getCategory($defaultCategory['eventID'], $defaultCategory['categoryID']);

        foreach ($tickets as $ticket) {
            $res[ucwords(strtolower($ticket->getName()))] = (int)$ticket->getId();
        }
        return $res;
    }

    /**
     * @param Badge $badge
     * @return ParticipantPost
     */
    private function badge2ParticipantForm(Badge $badge)
    {
        $participant = new ParticipantPost();
        $participant->setIdEvenement($badge->getEventID());
        $participant->setIdBillet($badge->getTicketID());
        $participant->setNom(strtoupper($badge->getNom()));

        $prenom = $badge->getPrenom();
        if ( !empty($badge->getPseudo()) ) { $prenom .= " «".$badge->getPseudo()."»"; }

        $participant->setPrenom($prenom);
        $participant->setEmail($badge->getEmail());
        $participant->setNotify($badge->getNotify());

        $form = new ParticipantForm();
        $form->setSociete($badge->getSociete());
        $form->setFonction($badge->getFonction());
        $participant->setForm($form);
        return $participant;
    }
}