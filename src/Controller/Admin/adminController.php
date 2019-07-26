<?php


namespace App\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class adminController
 * @package App\Controller\Admin
 * @Security("is_granted('ROLE_ADMIN')")
 */
class adminController extends AbstractController
{

    /**
     * @Route("/admin", name="adminPage")
     */
    public function adminPage()
    {
        $modules = [];
        if ( $this->isGranted('ROLE_SUPER_ADMIN') ) {
            $modules[] = [
                'name' => "Users",
                'route' => 'adminUsersListPage',
                'icon' => 'fas fa-users-cog',
            ];
        }

        return $this->render("admin/adminPage.html.twig", [
            'modules' => $modules,
        ]);
    }
}