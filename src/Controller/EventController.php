<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event/all', name: 'app_event_list', methods: ['GET'])]
    public function list(EventRepository $eventRepository): Response
    {
        return $this->render('event/list.html.twig', [
            'events' => $eventRepository->findAll()
        ]);
    }

    #[Route('/event', name: 'app_event_create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_event_list');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form
        ]);
    }
}
