<?php


namespace App\Controller;

use App\Service\ParameterService;
use Futurolan\WeezeventBundle\Client\WeezeventClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class homePageController
 * @package App\Controller
 */
class HomePageController extends AbstractController
{
    /** @var WeezeventClient */
    private $weezeventClient;

    /** @var ParameterService */
    private $parameterService;

    /** @var BadgeController */
    private $badgeController;

    /**
     * createBadgeController constructor.
     * @param WeezeventClient $weezeventClient
     * @param ParameterService $parameterService
     * @param BadgeController $badgeController
     */
    public function __construct(WeezeventClient $weezeventClient, ParameterService $parameterService, BadgeController $badgeController)
    {
        $this->weezeventClient = $weezeventClient;
        $this->parameterService = $parameterService;
        $this->badgeController = $badgeController;
    }

    /**
     * @Route("/", name="homePage")
     */
    public function homePageAction()
    {
        if ( is_null($this->getUser()) ) { return $this->redirectToRoute('loginPage'); }

        if ( !$this->weezeventClient->isApiAccessValid() ) {
            if ( $this->isGranted('ROLE_SUPER_ADMIN') ) {
                return $this->redirectToRoute('adminApiKeyPage');
            } else {
                return $this->redirectToRoute('apiErrorPage');
            }
        }

        $defaultEvent = $this->badgeController->getDefaultEvent();
        $tickets = $this->badgeController->getAllowedTickets();

        return $this->render("home/home.html.twig", [
            'defaultEvent' => $defaultEvent,
            'tickets' => $tickets,
        ]);
    }

    /**
     * @Route("/login", name="loginPage")
     */
    public function loginPageAction()
    {
        return $this->render("home/login.html.twig", []);
    }

    /**
     * @Route("/logout", name="logoutPage")
     */
    public function logoutPageAction()
    {
        return $this->redirectToRoute('homePage');
    }

    /**
     * @Route("/apiError", name="apiErrorPage")
     */
    public function apiErrorPageAction()
    {
        return $this->render("home/apiError.html.twig", []);
    }
}