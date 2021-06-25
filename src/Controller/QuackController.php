<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\Quack1Type;
use App\Repository\QuackRepository;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Validator\Constraints\DateTime;


class QuackController extends AbstractController
{
  //  const EDIT = 'EDIT';
    //const DELETE = 'DELETE';
    /**
     * @Route("/quack", name="quack_index", methods={"GET"})
     */
    public function index(): Response
    {
        $quackRepository = $this->getDoctrine()->getRepository(Quack::class);
        return $this->render('quack/index.html.twig', [
            'quacks' => $quackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/quack/new", name="quack_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $quack = new Quack();
        $quack->setAuthor($this->getUser());
        $quack->setCreatedAt(date_create());
        $form = $this->createForm(Quack1Type::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('duck_index');
        }

        return $this->render('quack/new.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/quack/show/{id}", name="quack_show", methods={"GET"})
     */
    public function show(Quack $quack): Response
    {
        return $this->render('quack/show.html.twig', [
            'quack' => $quack,
        ]);
    }

    /**
     * @Route("/quack/edit/{id}", name="quack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quack $quack): Response
    {
        $form = $this->createForm(Quack1Type::class, $quack);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('EDIT', $quack);
        if (!$this->isGranted('EDIT', $form)) {
           // return $this->render('/quack');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/edit.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/quack/delete/{id}", name="quack_delete", methods={"POST"})
     */
    public function delete(Quack $quack): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $this->denyAccessUnlessGranted('DELETE', $quack);
            $entityManager->remove($quack);
            $entityManager->flush();


        return $this->redirectToRoute('quack_index');
    }
}
