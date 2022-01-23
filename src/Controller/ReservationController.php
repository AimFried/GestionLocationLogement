<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CalendarRepository;
use App\Repository\LOGEMENTRepository;
use App\Repository\LOCATAIRERepository;
use App\Repository\RESERVATIONRepository;
use App\Entity\RESERVATION;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'reservation', methods: ['GET'])]
    public function reservation(RESERVATIONRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        return $this->render('Reservation/reservation.html.twig',
         ['reservations' => $reservations,]);
    }

    #[Route('/reservation/profile/{id}', name: 'profile_reservation',  methods: ['GET'])]
    public function profileLocataire(RESERVATIONRepository $reservationRepository,$id): Response
    {
        $reservations = $reservationRepository->find($id);
    
        return $this->render('Reservation/profileReservation.html.twig', 
        ['reservations' => $reservations,]);
    }

    #[Route('/reservation/{id}/modification', name: 'reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RESERVATION $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RESERVATION::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('reservation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/reservation/{id}', name: 'reservation_delete', methods: ['POST'])]
    public function delete(Request $request, RESERVATION $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation', [], Response::HTTP_SEE_OTHER);
    }
}
