<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Form\EditUserType;
use App\Repository\DuckRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * Liste les users du site
     * @Route ("/admin/users", name="users")
     *
     */
    public function usersList(DuckRepository $ducks)
    {
        return $this->render('admin/users.html.twig',[
            'users' => $ducks->findAll()
            ]);
    }

    /**
     * Modifications des users
     * @Route("admin/edit/{id}", name="edit_user")
     */
    public function editUser(Duck $duck, \Symfony\Component\HttpFoundation\Request $request){
        $form = $this->createForm(EditUserType::class, $duck);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($duck);
            $entityManager->flush();

            return $this->redirectToRoute('users');
        }
        return $this->render('admin/edituser.html.twig', [
            'userForm'=>$form->createView(),
            'users' => $duck
        ]);
    }
}
