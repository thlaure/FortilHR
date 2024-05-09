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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventController extends AbstractController
{
    #[Route('/event/all', name: 'app_event_list', methods: ['GET'])]
    public function list(EventRepository $eventRepository): Response
    {
        return $this->render('event/list.html.twig', [
            'events' => $eventRepository->findBy([], ['startDate' => 'DESC', 'endDate' => 'DESC']),
        ]);
    }

    #[Route('/event', name: 'app_event_create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request, ValidatorInterface $validator): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($event);
            if (count($errors) > 0) {
                return $this->render('event/create.html.twig', [
                    'form' => $form,
                    'errors' => $errors,
                ]);
            }

            $entityManager->persist($event);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_event_list');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form
        ]);
    }
}
