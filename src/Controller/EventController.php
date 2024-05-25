<?php

namespace App\Controller;

use App\Constant\Message;
use App\Entity\Event;
use App\Exception\DatabaseException;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Service\FileChecker;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale}', name: 'app_event_', locale: 'fr')]
class EventController extends AbstractController
{
    public function __construct(
        private LoggerInterface $logger,
        private FileUploader $fileUploader,
        private TranslatorInterface $translator,
        private string $targetDirectory
    ) {
    }

    #[Route('/back-office/event/list', name: 'list', methods: ['GET'])]
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

    #[Route('/back-office/event/create', name: 'create')]
    public function create(
        EntityManagerInterface $entityManager,
        Request $request,
        ValidatorInterface $validator,
        FileChecker $fileChecker
    ): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            foreach ($errors = $validator->validate($event) as $error) {
                $this->addFlash('error', $this->translator->trans($error->getMessage()));
            }
            if (count($errors) > 0) {
                return $this->redirectToRoute('app_event_create');
            }

            foreach ($formErrors = $form->getErrors(true) as $error) {
                $this->addFlash('error', $this->translator->trans($error->getMessage()));
            }
            if (count($formErrors) > 0) {
                return $this->redirectToRoute('app_event_create');
            }

            if ($form->isValid()) {
                /** @var ?UploadedFile $image */
                $image = $form->get('image')->getData();
                if ($image && $fileChecker->checkImageIsValid($image)) {
                    $imageName = $this->fileUploader->upload($image, $this->targetDirectory);
                    $event->setImageName($imageName);
                }

                try {
                    $entityManager->persist($event);
                    $entityManager->flush();

                    $this->addFlash('success', $this->translator->trans(Message::GENERIC_SUCCESS));
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                    $this->addFlash('error', $this->translator->trans(Message::GENERIC_ERROR));
                }

                return $this->redirectToRoute('app_event_list');
            }
        }

        return $this->render('event/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/back-office/event/{id}/delete', name: 'delete')]
    public function delete(Event $event, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($event);
            $entityManager->flush();

            $this->addFlash('success', $this->translator->trans(Message::GENERIC_SUCCESS));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $this->addFlash('error', $this->translator->trans(Message::GENERIC_ERROR));
        }

        return $this->redirectToRoute('app_event_list');
    }

    #[Route('/event/{id}', name: 'show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/back-office/event/{id}/edit', name: 'edit')]
    public function edit(Event $event, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $errors = $validator->validate($event);
            if (count($errors) > 0) {
                if ($errors[0] instanceof ConstraintViolation) {
                    $this->addFlash('error', $this->translator->trans($errors[0]->getMessage()));
                }

                return $this->redirectToRoute('app_event_edit', ['id' => $event->getId()]);
            }

            if ($form->isValid()) {
                try {
                    $entityManager->flush();

                    $this->addFlash('success', $this->translator->trans(Message::GENERIC_SUCCESS));
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                    $this->addFlash('error', $this->translator->trans(Message::GENERIC_ERROR));
                }

                return $this->redirectToRoute('app_event_list');
            }
        }

        return $this->render('event/create.html.twig', [
            'form' => $form,
        ]);
    }
}
