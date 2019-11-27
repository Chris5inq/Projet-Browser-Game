<?php

namespace App\Controller;

use App\Entity\Stuff;
use App\Form\StuffType;
use App\Repository\StuffRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stuff")
 */
class StuffController extends AbstractController
{
    /**
     * @Route("/", name="stuff_index", methods={"GET"})
     */
    public function index(StuffRepository $stuffRepository): Response
    {
        return $this->render('stuff/index.html.twig', [
            'stuffs' => $stuffRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="stuff_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stuff = new Stuff();
        $form = $this->createForm(StuffType::class, $stuff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stuff);
            $entityManager->flush();

            return $this->redirectToRoute('stuff_index');
        }

        return $this->render('stuff/new.html.twig', [
            'stuff' => $stuff,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stuff_show", methods={"GET"})
     */
    public function show(Stuff $stuff): Response
    {
        return $this->render('stuff/show.html.twig', [
            'stuff' => $stuff,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stuff_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Stuff $stuff): Response
    {
        $form = $this->createForm(StuffType::class, $stuff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stuff_index');
        }

        return $this->render('stuff/edit.html.twig', [
            'stuff' => $stuff,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stuff_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Stuff $stuff): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stuff->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stuff);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stuff_index');
    }
}
