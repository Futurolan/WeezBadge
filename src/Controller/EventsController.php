<?php


namespace App\Controller;

use App\Service\ParameterService;
use Futurolan\WeezeventBundle\Client\WeezeventClient;
use Futurolan\WeezeventBundle\Entity\Participant;
use Futurolan\WeezeventBundle\Entity\Team;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class listEventsController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER')")
 */
class EventsController extends AbstractController
{
    /** @var WeezeventClient */
    private $weezeventClient;

    /** @var ParameterService */
    private $parameterService;

    /**
     * listEventsController constructor.
     * @param WeezeventClient $weezeventClient
     * @param ParameterService $parameterService
     */
    public function __construct(WeezeventClient $weezeventClient, ParameterService $parameterService)
    {
        $this->weezeventClient = $weezeventClient;
        $this->parameterService = $parameterService;

        $this->weezeventClient->setApiKey($this->parameterService->get($this->parameterService::API_KEY));
        $this->weezeventClient->setApiToken($this->parameterService->get($this->parameterService::API_TOKEN));
    }

    /**
     * @Route("/events", name="eventsListPage")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function eventsListAction()
    {
        return $this->render("events/events.html.twig", [
            'events' => $this->weezeventClient->getEvents(false),
        ]);
    }

    /**
     * @Route("/event/{eventID}/ticket/{ticketID}", name="eventParticipantsByTicketPage")
     * @param string $eventID
     * @param string $ticketID
     * @return Response
     * @throws GuzzleException
     * @Security("is_granted('ROLE_USER')")
     */
    public function eventParticipantsByTicketAction(string $eventID, string $ticketID)
    {
        $ticket = $this->weezeventClient->getTicket($eventID, $ticketID);
        $participants = $this->weezeventClient->getParticipantsByTicket($ticketID);
        if ( $ticket->getGroupSize() > 0 ) {
            $isTeam = true;
            $teams = $this->participantsToTeams($participants);
            $participants = null;
        } else {
            $isTeam = false;
            $teams = null;
        }

        return $this->render("events/eventParticipants.html.twig", [
            'ticket' => $ticket,
            'isTeam' => $isTeam,
            'teams' => $teams,
            'participants' => $participants,
        ]);
    }


    /**
     * @param Participant[] $participants
     * @return Team[]
     */
    private function participantsToTeams(array $participants)
    {
        /** @var Team[] $teams */
        $teams = [];
        /** @var Participant $participant */
        foreach($participants as $participant) {
            if ( !key_exists($participant->getBuyer()->getIdAcheteur(), $teams) ) {
                $team = new Team();
                $team->setId($participant->getBuyer()->getIdAcheteur());
                $team->setName($this->getTeamName($participant));
                $team->setEmail($participant->getBuyer()->getEmailAcheteur());
                $team->setOwnerFirstName($participant->getBuyer()->getAcheteurFirstName());
                $team->setOwnerLastName($participant->getBuyer()->getAcheteurLastName());
                $teams[$participant->getBuyer()->getIdAcheteur()] = $team;
            }
            $teams[$participant->getBuyer()->getIdAcheteur()]->addMember($participant);
        }
        return $teams;
    }

    /**
     * @param Participant $participant
     * @return string
     */
    private function getTeamName(Participant $participant) {
        foreach ($participant->getBuyer()->getAnswers() as $anwser) {
            if ( $anwser->getLabel() === "Dénomination de l'équipe" ) { return $anwser->getValue(); }
        }
        return (string)$participant->getBuyer()->getIdAcheteur();
    }

    /**
     * @Route("/event/{eventID}", name="eventTicketsListPage")
     * @param string $eventID
     * @param ParameterService $parameterService
     * @return Response
     * @throws GuzzleException
     */
    public function eventTicketsAction(string $eventID, ParameterService $parameterService)
    {
        return $this->render("events/eventTickets.html.twig", [
            'eventTickets' => $this->weezeventClient->getTicketsByEvent($eventID),
            'DefaultCategory' => $parameterService->get($parameterService::DEFAULT_CATEGORY_NAME),
        ]);
    }

}