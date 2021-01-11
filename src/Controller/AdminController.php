<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'titre'=>'',
            'lien' =>'',
            'soustitre'=>'',
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function usersList(UserRepository $user) {
        return $this->render("admin/users.html.twig",[
            'titre'=>'Utilisateurs',
            'soustitre'=>'Liste Utilisateurs',
            'lien'=>'',
            'users' => $user->findAll()
        ]);
    }
    /**
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser(Request $request, User $user, EntityManagerInterface  $em) {

        $form = $this->createForm(EditUserType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/editUser.html.twig', [
            'titre'=>'Utilisateurs',
            'soustitre'=>'Modifier',
            'lien'=>'',

        'formUser' => $form->createView()]);
    }
}
