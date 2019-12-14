<?php


namespace App\Controller;

use App\Entity\Badge;
use App\Entity\Import;
use App\Entity\Log;
use App\Form\BadgeFormType;
use App\Form\ImportFormType;
use App\Service\ParameterService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Futurolan\WeezeventBundle\Client\WeezeventClient;
use Futurolan\WeezeventBundle\Entity\Event;
use Futurolan\WeezeventBundle\Entity\ParticipantForm;
use Futurolan\WeezeventBundle\Entity\ParticipantPost;
use Futurolan\WeezeventBundle\Entity\Ticket;
use JMS\Serializer\SerializerInterface;
use League\Csv\Reader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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

    /** @var EntityManagerInterface */
    private $em;

    /**
     * createBadgeController constructor.
     * @param SerializerInterface $serializer
     * @param WeezeventClient $weezeventClient
     * @param ParameterService $parameterService
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     */
    public function __construct(SerializerInterface $serializer, WeezeventClient $weezeventClient, ParameterService $parameterService, ValidatorInterface $validator, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->weezeventClient = $weezeventClient;
        $this->parameterService = $parameterService;
        $this->validator = $validator;

        $this->weezeventClient->setApiToken($this->parameterService->get($this->parameterService::API_TOKEN));
    }

    /**
     * @return Event|null
     * @throws GuzzleException
     */
    public function getDefaultEvent()
    {
        $defaultCategory = $this->parameterService->get($this->parameterService::DEFAULT_CATEGORY_NAME);
        return $this->weezeventClient->getEvent($defaultCategory['eventID']);
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
        if ( !$this->isGranted('ROLE_'.$eventID.'_'.$ticketID) && !$this->isGranted('ROLE_ADMIN') ) {
            throw new AccessDeniedException("Vous n'avez pas le droit de gérer cette catégorie de badge.");
        }

        $log = $this->em->getRepository(Log::class)->findOneBy(['participantID' => (int)$participantID]);
        try{
            $this->weezeventClient->deleteParticipant($eventID, $participantID);
            if ( $log instanceof Log) {
                $log->setDeletedID($this->getUser()->getId());
                $log->setDeletedEmail($this->getUser()->getEmail());
                $log->setDeletedName($this->getUser()->getName());
                $log->setDeletedDate(new DateTime());
                $this->em->persist($log);
                $this->em->flush();
            }

            $this->addFlash('success', "Badge supprimé avec succès !");
        } catch(Exception $e) {
            $this->addFlash('error', "Une erreur est survenue lors de la suppression du badge : ".$e->getMessage());
        }

        return $this->redirectToRoute('eventParticipantsByTicketPage', ['eventID' => $eventID, 'ticketID' => $ticketID]);
    }

    /**
     * @Route("/event/{eventID}/ticket/{ticketID}/pdf/{participantID}", methods={"GET"}, name="getPdfBadge")
     * @param string $eventID
     * @param string $ticketID
     * @param string $participantID
     * @return Response
     * @throws GuzzleException
     */
    public function getPdfBadge(string $eventID, string $ticketID, string $participantID)
    {
        if (!$this->isGranted('ROLE_' . $eventID . '_' . $ticketID) && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'avez pas le droit de gérer cette catégorie de badge.");
        }

        try {
            $badgeUrl = $this->weezeventClient->getBadgeUrl($eventID, $participantID);
            return $this->redirect($badgeUrl);
        } catch(Exception $e) {
            $this->addFlash('error', "Une erreur est survenue lors du téléchargement du badge en pdf : ".$e->getMessage());
        }

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

            if ( !$this->isGranted('ROLE_'.$badge->getEventID().'_'.$badge->getTicketID()) && !$this->isGranted('ROLE_ADMIN') ) {
                throw new AccessDeniedException("Vous n'avez pas le droit de gérer cette catégorie de badge.");
            }

            try {
                $response = $this->weezeventClient->addParticipant($this->badge2ParticipantForm($badge));
                if ( !key_exists('total_added', $response) || $response['total_added'] !== 1 ) {
                    return $this->creationError($form, "Erreur Weezevent");
                } else {
                    $log = new Log();
                    $log->setCreatedID($this->getUser()->getId());
                    $log->setCreatedEmail($this->getUser()->getEmail());
                    $log->setCreatedName($this->getUser()->getName());
                    $log->setEventID($badge->getEventID());
                    $log->setTicketID($badge->getTicketID());
                    $log->setParticipantID($response['participants'][0]['id_participant']);
                    $log->setHash($badge->getHash());

                    $this->em->persist($log);
                    $this->em->flush();
                }
            } catch(Exception $e) {
                return $this->creationError($form, $e->getMessage());
            }

            $this->addFlash('success', "Badge créé avec succès !");
            return $this->redirectToRoute('eventParticipantsByTicketPage', ['eventID' => $badge->getEventID(), 'ticketID' => $badge->getTicketID()]);
        }

        return $this->render('badge/badgeForm.html.twig', [
            'badgeForm' => $form->createView(),
        ]);
    }

    /**
     * @param FormInterface $form
     * @param string $errorMsg
     * @return Response
     */
    private function creationError(FormInterface $form, string $errorMsg)
    {
        $this->addFlash('error', "Erreur lors de la création du badge : ".$errorMsg);

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
        /** @var Badge[] $badges */
        $badges = $this->serializer->deserialize($request->getContent(), 'array<App\Entity\Badge>', 'json');
        $participants = [];
        foreach ($badges as $badge) {
            if ( !$this->isGranted('ROLE_'.$badge->getEventID().'_'.$badge->getTicketID()) && !$this->isGranted('ROLE_ADMIN') ) {
                throw new AccessDeniedException("Vous n'avez pas le droit de gérer cette catégorie de badge.");
            }
            $participants[] = $this->badge2ParticipantForm($badge);
        }

        try{
            $this->weezeventClient->addParticipants($participants);
        } catch(Exception $e) {
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
     * @return int|null
     */
    public function getDefaultEventId(): ?int
    {
        $defaultCategory = $this->parameterService->get($this->parameterService::DEFAULT_CATEGORY_NAME);
        if ( key_exists('eventID', $defaultCategory) && !empty($defaultCategory['eventID']) ) {
            return (int)$defaultCategory['eventID'];
        }
        return null;
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
     * @return Ticket[]
     * @throws GuzzleException
     */
    private function getTickets()
    {
        try{
            $defaultCategory = $this->parameterService->get($this->parameterService::DEFAULT_CATEGORY_NAME);
            if ( empty($defaultCategory['eventID']) || empty($defaultCategory['eventID']) ) { return []; }
            $tickets = $this->weezeventClient->getCategory($defaultCategory['eventID'], $defaultCategory['categoryID']);
            return $tickets;
        } catch(Exception $e) {
            return [];
        }
    }

    /**
     * @return array
     * @throws GuzzleException
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function getTicketsForm()
    {
        $res = [];
        $tickets = $this->getTickets();
        foreach ($tickets as $ticket) {
            $res[ucwords(strtolower($ticket->getName()))] = (int)$ticket->getId();
        }
        ksort($res);
        return $res;
    }

    /**
     * @return Ticket[]
     * @throws GuzzleException
     */
    public function getAllowedTickets()
    {
        $res = [];
        $tickets = $this->getTickets();
        $defaultCategory = $this->parameterService->get($this->parameterService::DEFAULT_CATEGORY_NAME);

        foreach ($tickets as $ticket) {
            if ( $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_'.$defaultCategory['eventID'].'_'.$ticket->getId()) ) {
                $res[] = $ticket;
            }
        }
        return $res;
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function getAllowedTicketsForm()
    {
        $res = ['' => ''];
        $tickets = $this->getAllowedTickets();

        foreach ($tickets as $ticket) {
            $res[ucwords(strtolower($ticket->getName()))] = (int)$ticket->getId();
        }
        ksort($res);
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


//$datas = '{"participants":[{"id_evenement":'.$app['weezevent.id_event'].',"barcode_id":'.$barcode_participant.'}],"return_ticket_url":1}';
//$ticket = json_decode($guzzle->request('PATCH', 'https://api.weezevent.com/v3/participants?api_key='.$app['weezevent.api_key'].'&access_token='.$app['weezevent.access_token'].'&data='.$datas, array('form_params' => array('data' => $datas), 'headers' => array('Content-type' => 'application/x-www-form-urlencoded', 'Charset' => 'utf-8')))->getBody());
//$url = $ticket->participants[0]->ticket_url;
//
//header('Location: '.$url);


}