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
class homePageController extends AbstractController
{
    /** @var WeezeventClient */
    private $weezeventClient;

    /** @var ParameterService */
    private $parameterService;

    /**
     * createBadgeController constructor.
     * @param WeezeventClient $weezeventClient
     * @param ParameterService $parameterService
     */
    public function __construct(WeezeventClient $weezeventClient, ParameterService $parameterService)
    {
        $this->weezeventClient = $weezeventClient;
        $this->parameterService = $parameterService;
    }

    /**
     * @Route("/", name="homePage")
     */
    public function homePageAction()
    {
        if (is_null($this->getUser())) { return $this->redirectToRoute('loginPage'); }

        $defaultCategory = $this->parameterService->get($this->parameterService::DEFAULT_CATEGORY_NAME);
        $defaultEvent = $this->weezeventClient->getEvent($defaultCategory['eventID']);

        return $this->render("home/home.html.twig", [
            'defaultEvent' => $defaultEvent,
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
}