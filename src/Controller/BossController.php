<?php

namespace App\Controller;

use App\Entity\Boss;
use App\Form\BossType;
use App\Form\BossNewType;
use App\Repository\BossRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/boss")
 */
class BossController extends AbstractController
{
    /**
     * @Route("/", name="boss_index", methods={"GET"})
     */
    public function index(BossRepository $bossRepository): Response
    {
        return $this->render('boss/index.html.twig', [
            'bosses' => $bossRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="boss_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $boss = new Boss();
        $form = $this->createForm(BossNewType::class, $boss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($boss);
            $entityManager->flush();

            return $this->redirectToRoute('boss_index');
        }

        return $this->render('boss/new.html.twig', [
            'boss' => $boss,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="boss_show", methods={"GET"})
     */
    public function show(Boss $boss): Response
    {
        return $this->render('boss/show.html.twig', [
            'boss' => $boss,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="boss_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Boss $boss): Response
    {
        $form = $this->createForm(BossType::class, $boss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boss_index');
        }

        return $this->render('boss/edit.html.twig', [
            'boss' => $boss,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="boss_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Boss $boss): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boss->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boss);
            $entityManager->flush();
        }

        return $this->redirectToRoute('boss_index');
    }
}
