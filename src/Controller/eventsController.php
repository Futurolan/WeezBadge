<?php


namespace App\Controller;


use Futurolan\WeezeventBundle\Client\WeezeventClient;
use Futurolan\WeezeventBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     */
    public function eventsListAction()
    {
        dump($this->weezeventClient->getParticipantsByEvent('460180')[0]);
        return $this->render("listEvent/events.html.twig", [
            'events' => $this->weezeventClient->getEvents(),
        ]);
    }

    /**
     * @Route("/event/{id}", name="eventPage")
     * @param Event $event
     */
    public function getEventAction(Event $event)
    {
        dump($event);
    }
}