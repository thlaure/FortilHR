<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event/all', name: 'app_event_list')]
    public function list(EventRepository $eventRepository): Response
    {
        return $this->render('event/list.html.twig', [
            'events' => $eventRepository->findAll()
        ]);
    }
}
