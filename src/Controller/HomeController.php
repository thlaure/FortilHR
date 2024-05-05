<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $email = 'thomas.laure@fortil.group'; // TODO: get email from AD/Fortil SSO

        return $this->render('home/index.html.twig', [
            'qrcode_data' => hash('md5', $email.time())
        ]);
    }
}
