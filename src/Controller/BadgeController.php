<?php


namespace App\Controller;

use App\Entity\Badge;
use App\Entity\Import;
use App\Form\BadgeFormType;
use App\Form\ImportFormType;
use App\Service\ParameterService;
use Futurolan\WeezeventBundle\Client\WeezeventClient;
use Futurolan\WeezeventBundle\Entity\ParticipantForm;
use Futurolan\WeezeventBundle\Entity\ParticipantPost;
use JMS\Serializer\SerializerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /** @var ValidatorInterface */
    private $validator;

    /**
     * createBadgeController constructor.
     * @param SerializerInterface $serializer
     * @param WeezeventClient $weezeventClient
     * @param ParameterService $parameterService
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, WeezeventClient $weezeventClient, ParameterService $parameterService, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->weezeventClient = $weezeventClient;
        $this->parameterService = $parameterService;
        $this->validator = $validator;
    }

    /**
     * @Route("/event/{eventID}/ticket/{ticketID}/delete/{participantID}", methods={"GET"}, name="deleteParticipant")
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
     * @throws GuzzleException
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
            $data = $this->importToBadges($import);
            return $this->render('badge/badgesConfirm.html.twig', [
                'data' => $data,
                'eventID' => $import->getEventID(),
                'ticketID' => $import->getTicketID(),
                'json' => $this->serializer->serialize($data['badges'], 'json'),
            ]);
        }

        return $this->render('badge/badgesImport.html.twig', [
            'importForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/badge/import/confirm", methods={"POST"}, name="confirmImportBadgesPage")
     * @param Request $request
     * @return Response
     * @throws GuzzleException
     */
    public function confirmImportBadges(Request $request)
    {
        $badges = $this->serializer->deserialize($request->getContent(), 'array<App\Entity\Badge>', 'json');
        $participants = [];
        foreach ($badges as $badge) { $participants[] = $this->badge2ParticipantForm($badge); }

        try{
            $this->weezeventClient->addParticipants($participants);
        } catch(\Exception $e) {
            return new Response($e->getMessage(), 500);
        }

        return new Response(null, 204);
    }

    /**
     * @param Import $import
     * @return array
     */
    private function importToBadges(Import $import)
    {
        $response = [
            'badges' => [],
            'errors' => [],
        ];

        $reader = Reader::createFromString($import->getCsv());
        $records = $reader->getRecords(['nom', 'prenom', 'pseudo', 'societe', 'fonction', 'email']);
        foreach ($records as $offset => $record) {
            if ( !empty($record['email']) ) {
                $badge = new Badge();
                $badge->setEventID($import->getEventID());
                $badge->setTicketID($import->getTicketID());
                $badge->setNom(trim($record['nom']));
                $badge->setPrenom(trim($record['prenom']));
                $badge->setPseudo(trim($record['pseudo']));
                $badge->setSociete(trim($record['societe']));
                $badge->setFonction(trim($record['fonction']));
                $badge->setEmail(trim($record['email']));
                $badge->setNotify($import->getNotify());
                $errors = $this->validator->validate($badge);

                if ( count($errors) === 0 ) {
                    $response['badges'][] = $badge;
                } else {
                    $record = array_map('trim', $record);
                    $response['errors'][] = [
                        'badge' => implode(',', $record),
                        'message' => $errors->get(0)->getMessage(),
                    ];
                }
            }
        }

        return $response;
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