<?php


namespace App\Controller;


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

    /**
     * homePageController constructor.
     * @param WeezeventClient $weezeventClient
     */
    public function __construct(WeezeventClient $weezeventClient)
    {
        $this->weezeventClient = $weezeventClient;
    }

    /**
     * @Route("/", name="homePage")
     */
    public function homePageAction()
    {
        if (is_null($this->getUser())) {
            return $this->redirectToRoute('loginPage');
        }

        dump($this->weezeventClient->getApiKey());
        dump($this->weezeventClient->getToken());

        return $this->render("home/home.html.twig", [
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