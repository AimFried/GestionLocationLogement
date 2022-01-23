<?php

namespace App\Controller;

use App\Entity\RESERVATION;
use App\Form\RESERVATIONType;
use App\Repository\RESERVATIONRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/', name: 'test_index', methods: ['GET'])]
    public function index(RESERVATIONRepository $rESERVATIONRepository): Response
    {
        return $this->render('test/index.html.twig', [
            'r_e_s_e_r_v_a_t_i_o_ns' => $rESERVATIONRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'test_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rESERVATION = new RESERVATION();
        $form = $this->createForm(RESERVATIONType::class, $rESERVATION);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rESERVATION);
            $entityManager->flush();

            return $this->redirectToRoute('test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('test/new.html.twig', [
            'r_e_s_e_r_v_a_t_i_o_n' => $rESERVATION,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'test_show', methods: ['GET'])]
    public function show(RESERVATION $rESERVATION): Response
    {
        return $this->render('test/show.html.twig', [
            'r_e_s_e_r_v_a_t_i_o_n' => $rESERVATION,
        ]);
    }

    #[Route('/{id}/edit', name: 'test_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RESERVATION $rESERVATION, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RESERVATIONType::class, $rESERVATION);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('test/edit.html.twig', [
            'r_e_s_e_r_v_a_t_i_o_n' => $rESERVATION,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'test_delete', methods: ['POST'])]
    public function delete(Request $request, RESERVATION $rESERVATION, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rESERVATION->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rESERVATION);
            $entityManager->flush();
        }

        return $this->redirectToRoute('test_index', [], Response::HTTP_SEE_OTHER);
    }
}
