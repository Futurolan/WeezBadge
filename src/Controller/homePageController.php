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
        return $this->render("home/home.html.twig", [
            'user' => $this->getUser(),
        ]);
    }
}