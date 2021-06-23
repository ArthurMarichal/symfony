<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Form\DuckType;
use App\Form\RegistrationFormType;
use App\Repository\DuckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DuckController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    /**
     * @Route("/duck/new", name="duck_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $duck = new Duck();
        $form = $this->createForm(DuckType::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($duck);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/new.html.twig', [
            'duck' => $duck,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/duck", name="duck_index", methods={"GET"})
     */
    public function index(): Response
    {
        $duckRepository = $this->getDoctrine()->getRepository(Duck::class);
        return $this->render('security/index.html.twig', [
            'duck' => $duckRepository->findAll(),
        ]);
    }
    /**
     * @Route("/duck/show/{id}", name="duck_show", methods={"GET"})
     */
    public function show(Duck $duck): Response
    {
        return $this->render('security/show.html.twig', [
            'duck' => $duck,
        ]);
    }

    /**
     * @Route("/duck/edit/{id}", name="duck_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Duck $duck,  UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $duck->setPassword(
                $passwordEncoder->encodePassword(
                    $duck,
                    $form->get('plainPassword')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('duck_index');
        }

        return $this->render('security/edit.html.twig', [
            'duck' => $duck,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/duck/delete/{id}", name="duck_delete", methods={"GET"})
     */
    public function delete(Duck $duck): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($duck);
        $entityManager->flush();


        return $this->redirectToRoute('duck_index');
    }
}
