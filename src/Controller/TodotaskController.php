<?php

namespace App\Controller;

use App\Entity\Todotask;
use App\Form\TodotaskType;
use App\Repository\TodolistRepository;
use App\Repository\TodotaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class TodotaskController extends AbstractController
{


    /**
     * @Route("/todolist/{listid}/addtask", name="todotask_new", methods={"GET","POST"})
     */
    public function new(Request $request, TodolistRepository $todolistRepository, $listid): Response
    {
        $todotask = new Todotask();
        $form = $this->createForm(TodotaskType::class, $todotask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todotask->setTodolist($todolistRepository->find($listid));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todotask);
            $entityManager->flush();

            return $this->redirectToRoute('todolist_show', ['id' => $listid]);
        }

        return $this->render('todotask/new.html.twig', [
            'todotask' => $todotask,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/todotask/{id}/edit", name="todotask_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Todotask $todotask): Response
    {
        $form = $this->createForm(TodotaskType::class, $todotask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('todolist_show', ['id' => $todotask->getTodolist()->getId()]);
        }

        return $this->render('todotask/edit.html.twig', [
            'todotask' => $todotask,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/todotask/{id}/togglestatus", name="todotask_togglestatus")
     * @param TodotaskRepository $todotaskRepository
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function toggleStatus(TodotaskRepository $todotaskRepository, $id, EntityManagerInterface $entityManager)
    {
        $todotask = $todotaskRepository->find($id);
        $todotask->setCompleted(!$todotask->getCompleted());
        $entityManager->persist($todotask);
        $entityManager->flush();

        return $this->redirectToRoute('todolist_show', ['id' => $todotask->getTodolist()->getId()]);
    }
}