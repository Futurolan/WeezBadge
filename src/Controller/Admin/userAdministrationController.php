<?php


namespace App\Controller\Admin;


use App\Entity\User;
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

    /**
     * userAdministrationController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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

            $this->addFlash('success', "User ".$user->getEmail()." created successfully !");

            return $this->redirectToRoute('adminUsersListPage');
        }

        return $this->render('admin/newUserForm.html.twig', [
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

            $this->addFlash('success', "User ".$user->getEmail()." edited successfully !");

            return $this->redirectToRoute('adminUsersListPage');
        }

        return $this->render('admin/editUserForm.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}