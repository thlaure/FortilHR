<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(NotificationRepository $notificationRepository): Response
    {
        $email = 'thomas.laure@fortil.group'; // TODO: get email from AD/Fortil SSO
        $unreadNotifications = $notificationRepository->findBy(['isRead' => false]);

        return $this->render('home/index.html.twig', [
            'qrcode_data' => hash('md5', $email.time()),
            'unread_notifications' => $unreadNotifications
        ]);
    }
}
