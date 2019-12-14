<?php


namespace App\Controller\Admin;


use App\Service\ParameterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class adminController
 * @package App\Controller\Admin
 * @Security("is_granted('ROLE_ADMIN')")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="adminPage")
     */
    public function adminPage()
    {
        $modules = [];

        if ( $this->isGranted('ROLE_ADMIN') ) {
            $modules[] = [
                'name' => "Événements",
                'route' => 'eventsListPage',
                'icon' => 'far fa-calendar-alt',
            ];
        }

        if ( $this->isGranted('ROLE_SUPER_ADMIN') ) {
            $modules[] = [
                'name' => "Utilisateurs",
                'route' => 'adminUsersListPage',
                'icon' => 'fas fa-users-cog',
            ];
        }

        if ( $this->isGranted('ROLE_SUPER_ADMIN') ) {
            $modules[] = [
                'name' => "Token API",
                'route' => 'adminApiKeyPage',
                'icon' => 'fas fa-key',
            ];
        }

        return $this->render("admin/adminPage.html.twig", [
            'modules' => $modules,
        ]);
    }

    /**
     * @Route("/admin/setDefaultCategory", name="adminSetDefaultCategory")
     * @param Request $request
     * @param ParameterService $parameterService
     * @return Response
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function setDefaultCategory(Request $request, ParameterService $parameterService)
    {
        $data = json_decode($request->getContent(), true);
        if ( key_exists('eventID', $data) && key_exists('categoryID', $data) ) {
            $parameterService->set($parameterService::DEFAULT_CATEGORY_NAME, $data);
            return new Response(null, 204);
        }
        return new Response('Invalid Data', 500);
    }
}