<?php


namespace App\Controller;


use App\Service\ParameterService;
use Futurolan\WeezeventBundle\Client\WeezeventClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class menuController
 * @package App\Controller
 */
class menuController extends AbstractController
{
    public function dynamicMenu(ParameterService $parameterService, WeezeventClient $weezeventClient)
    {
        $defaultCategory = $parameterService->get($parameterService::DEFAULT_CATEGORY_NAME);
        if ( !empty($defaultCategory['eventID']) && !empty($defaultCategory['eventID']) && $this->isGranted('ROLE_USER') ) {
            $tickets = $weezeventClient->getCategory($defaultCategory['eventID'], $defaultCategory['categoryID']);
        } else {
            $tickets = [];
        }

        return $this->render("menu/menu.html.twig", [
            'tickets' => $tickets,
            'eventID' => $defaultCategory['eventID'],
        ]);
    }



}