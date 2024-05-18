<?php

namespace App\Controller;

use App\Exception\DatabaseException;
use App\Repository\EventRepository;
use App\Repository\HumanResourcesFormRepository;
use App\Repository\NotificationRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale}', name: 'app_home_', locale: 'en')]
class HomeController extends AbstractController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    #[Route('/', name: 'index')]
    public function index(NotificationRepository $notificationRepository, EventRepository $eventRepository, HumanResourcesFormRepository $hrFormRepository): Response
    {
        try {
            $email = 'thomas.laure@fortil.group'; // TODO: get email from AD/Fortil SSO
            $unreadNotifications = $notificationRepository->findBy(['isRead' => false]);
            $event = $eventRepository->findOneBy([], ['startDate' => 'desc']);
            $hrForm = $hrFormRepository->findOneBy([], ['id' => 'desc']);
    
            return $this->render('home/index.html.twig', [
                'qrcode_data' => hash('md5', $email.time()),
                'unread_notifications' => $unreadNotifications,
                'event' => $event,
                'hr_form' => $hrForm,
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new DatabaseException($e->getMessage());
        }
    }
}
