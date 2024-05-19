<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale}', name: 'app_backoffice_', locale: 'fr')]
class BackOfficeController extends AbstractController
{
    #[Route('/back-office', name: 'index')]
    public function index(): Response
    {
        return $this->render('back_office/index.html.twig');
    }
}
