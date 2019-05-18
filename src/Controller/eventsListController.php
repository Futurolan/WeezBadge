<?php


namespace App\Controller;


use Futurolan\WeezeventBundle\Client\WeezeventClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class listEventsController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER')")
 */
class eventsListController extends AbstractController
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
        dump($this->weezeventClient->getEvents());
        return $this->render("listEvent/events.html.twig", [
            'events' => $this->weezeventClient->getEvents(),
        ]);
    }
}