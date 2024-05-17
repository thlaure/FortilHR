<?php

namespace App\Controller;

use App\Entity\Event;
use App\Exception\DatabaseException;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventController extends AbstractController
{
    public function __construct(private LoggerInterface $logger, private FileUploader $fileUploader)
    {
    }

    #[Route('/back-office/event/all', name: 'app_event_list', methods: ['GET'])]
    public function list(EventRepository $eventRepository): Response
    {
        try {
            $events = $eventRepository->findBy([], ['startDate' => 'DESC', 'endDate' => 'DESC']);

            return $this->render('event/list.html.twig', [
                'events' => $events,
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new DatabaseException($e->getMessage());
        }
    }

    #[Route('/back-office/event', name: 'app_event_create', methods: ['GET', 'POST'])]
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

            $image = $form->get('image')->getData();
            if ($image) {
                $imageName = $this->fileUploader->upload($image);
                $event->setImageName($imageName);
            }

            try {
                $entityManager->persist($event);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->addFlash('error', $e->getMessage());
            }
            
            return $this->redirectToRoute('app_event_list');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/back-office/event/{id}/delete', name: 'app_event_delete')]
    public function delete(Event $event, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($event);
            $entityManager->flush();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app_event_list');
    }

    #[Route('/event/{id}', name: 'app_event_show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
}
