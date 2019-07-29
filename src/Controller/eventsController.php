<?php


namespace App\Controller;


use App\Service\ParameterService;
use Futurolan\WeezeventBundle\Client\WeezeventClient;
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
class eventsController extends AbstractController
{
    /** @var WeezeventClient */
    private $weezeventClient;

    /**
     * listEventsController constructor.
     * @param WeezeventClient $weezeventClient
     */
    public function __construct(WeezeventClient $weezeventClient)
    {
        $this->weezeventClient = $weezeventClient;
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
        return $this->render("events/eventParticipants.html.twig", [
            'ticket' => $this->weezeventClient->getTicket($eventID, $ticketID),
            'participants' => $this->weezeventClient->getParticipantsByTicket($ticketID),
        ]);
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

//    /**
//     * @Route("/event/{eventID}", name="eventPage")
//     * @param string $eventID
//     * @return Response
//     * @throws GuzzleException
//     */
//    public function eventParticipantsAction(string $eventID)
//    {
//        return $this->render("events/eventParticipants.html.twig", [
//            'participants' => $this->weezeventClient->getParticipantsByEvent($eventID),
//        ]);
//    }
}