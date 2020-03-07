<?php

namespace App\Controller;

use App\Entity\Todolist;
use App\Form\TodolistType;
use App\Repository\TodolistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * @Route("/")
 */
class TodolistController extends AbstractController
{
    /**
     * @Route("/", name="todolist_index", methods={"GET"})
     * @param TodolistRepository $todolistRepository
     * @return Response
     */
    public function index(TodolistRepository $todolistRepository): Response
    {
        return $this->render('todolist/index.html.twig', [
            'todolists' => $todolistRepository->findAll(),
        ]);
    }

    /**
     * @Route("/todolist/new", name="todolist_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $todolist = new Todolist();
        $form = $this->createForm(TodolistType::class, $todolist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todolist);
            $entityManager->flush();

            return $this->redirectToRoute('todolist_show', ['id' => $todolist->getId()]);
        }

        return $this->render('todolist/new.html.twig', [
            'todolist' => $todolist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/todolist/{id}", name="todolist_show", methods={"GET"})
     * @param Todolist $todolist
     * @return Response
     */
    public function show(Todolist $todolist): Response
    {
        return $this->render('todolist/show.html.twig', [
            'todolist' => $todolist,
        ]);
    }

    /**
     * @Route("/todolist/{id}/edit", name="todolist_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Todolist $todolist
     * @return Response
     */
    public function edit(Request $request, Todolist $todolist): Response
    {
        $form = $this->createForm(TodolistType::class, $todolist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('todolist_show', ['id' => $todolist->getId()]);
        }

        return $this->render('todolist/edit.html.twig', [
            'todolist' => $todolist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/todolist/{id}/delete", name="todolist_delete")
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @param TodolistRepository $todolistRepository
     * @return Response
     */
    public function delete($id, EntityManagerInterface $entityManager, TodolistRepository $todolistRepository): Response
    {
        $todolist = $todolistRepository->find($id);

        foreach ($todolist->getTodotasks() as $todotask) {
            $entityManager->remove($todotask);
        }

        $entityManager->remove($todolist);
        $entityManager->flush();

        return $this->redirectToRoute('todolist_index');
    }

    /**
     * @Route("/todolist/{id}/clear", name="todolist_clear")
     * @param $id
     * @param TodolistRepository $todolistRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function clear($id, TodolistRepository $todolistRepository, EntityManagerInterface $entityManager)
    {
        $todolist = $todolistRepository->find($id);
        foreach ($todolist->getTodotasks() as $todotask) {
            if ($todotask->getCompleted()) {
                $entityManager->remove($todotask);
            }
        }

        $entityManager->flush();
        return $this->redirectToRoute('todolist_show', ['id' => $id]);
    }
}