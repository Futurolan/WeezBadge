<?php


namespace App\Controller\Admin;


use App\Controller\BadgeController;
use App\Entity\Acl;
use App\Entity\User;
use App\Form\UserAclFormType;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class adminController
 * @package App\Controller
 * @Security("is_granted('ROLE_SUPER_ADMIN')")
 */
class userAdministrationController extends AbstractController
{

    /** @var EntityManagerInterface */
    private $em;

    /** @var BadgeController */
    private $badgeController;

    /**
     * userAdministrationController constructor.
     * @param EntityManagerInterface $em
     * @param BadgeController $badgeController
     */
    public function __construct(EntityManagerInterface $em, BadgeController $badgeController)
    {
        $this->em = $em;
        $this->badgeController = $badgeController;
    }

    /**
     * @Route("/admin/users", name="adminUsersListPage")
     * @param UserRepository $repository
     * @return Response
     */
    public function showUsers(UserRepository $repository)
    {
        return $this->render("admin/usersList.html.twig", [
            'users' => $repository->findAll(),
        ]);
    }


    /**
     * @Route("/admin/user/new", name="adminNewUserPage")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newUser(Request $request)
    {
        $form = $this->createForm(UserFormType::class);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            /** @var User $user */
            $user = $form->getData();

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', "L'utilisateur ".$user->getEmail()." a été créé avec succès !");

            return $this->redirectToRoute('adminUsersListPage');
        }

        return $this->render('admin/newUser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/user/{id}/edit", name="adminEditUserPage")
     * @param User $user
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editUser(User $user, Request $request)
    {
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', "L'utilisateur ".$user->getEmail()." a été édité avec succès !");

            return $this->redirectToRoute('adminUsersListPage');
        }

        return $this->render('admin/editUser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/user/{id}/acl", name="adminUserAclPage")
     * @param User $user
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAcl(User $user, Request $request)
    {

        $acl = new Acl();
        $acl->setEventId($this->badgeController->getDefaultEventId());
        $acl->rolesToAcl($user->getRoles());

        $form = $this->createForm(UserAclFormType::class, $acl);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            if ( !in_array('ROLE_SUPER_ADMIN', $user->getRoles()) && !in_array('ROLE_ADMIN', $user->getRoles()) ) {
                $user->setRoles(array_merge(['ROLE_USER'], $acl->aclToRoles()));
                $this->em->persist($user);
                $this->em->flush();

                $this->addFlash('success', "Les droits ".$user->getEmail()." ont été édités avec succès !");
                return $this->redirectToRoute('adminUsersListPage');
            }
        }

        return $this->render("admin/editUserAcl.html.twig", [
            'user' => $user,
            'aclForm' => $form->createView(),
        ]);
    }
}