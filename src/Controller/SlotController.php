<?php

namespace App\Controller;

use App\Entity\Slot;
use App\Form\SlotType;
use App\Repository\SlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/slot")
 */
class SlotController extends AbstractController
{
    /**
     * @Route("/", name="slot_index", methods={"GET"})
     */
    public function index(SlotRepository $slotRepository): Response
    {
        return $this->render('slot/index.html.twig', [
            'slots' => $slotRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="slot_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $slot = new Slot();
        $form = $this->createForm(SlotType::class, $slot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($slot);
            $entityManager->flush();

            return $this->redirectToRoute('slot_index');
        }

        return $this->render('slot/new.html.twig', [
            'slot' => $slot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slot_show", methods={"GET"})
     */
    public function show(Slot $slot): Response
    {
        return $this->render('slot/show.html.twig', [
            'slot' => $slot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="slot_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Slot $slot): Response
    {
        
        
        $form = $this->createForm(SlotType::class, $slot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('slot_index');
        }

        return $this->render('slot/edit.html.twig', [
            'slot' => $slot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slot_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Slot $slot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$slot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($slot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('slot_index');
    }
}
