<?php


namespace App\Controller;


use App\Service\ParameterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class menuController
 * @package App\Controller
 */
class menuController extends AbstractController
{
    /** @var BadgeController */
    private $badgeController;

    /**
     * createBadgeController constructor.
     * @param BadgeController $badgeController
     */
    public function __construct(BadgeController $badgeController)
    {
        $this->badgeController = $badgeController;
    }

    /**
     * @param ParameterService $parameterService
     * @return Response
     * @throws GuzzleException
     */
    public function dynamicMenu(ParameterService $parameterService)
    {
        $defaultCategory = $parameterService->get($parameterService::DEFAULT_CATEGORY_NAME);
        $tickets = $this->badgeController->getAllowedTickets();

        return $this->render("menu/menu.html.twig", [
            'tickets' => $tickets,
            'eventID' => $defaultCategory['eventID'],
        ]);
    }



}