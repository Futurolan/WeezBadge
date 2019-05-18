<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class homePageController
 * @package App\Controller
 */
class homePageController extends AbstractController
{

    /**
     * @Route("/", name="homePage")
     */
    public function homePageAction()
    {
        if (is_null($this->getUser())) {
            return $this->redirectToRoute('loginPage');
        }

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