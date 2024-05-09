<?php

namespace App\Controller;

use App\Repository\FormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FormController extends AbstractController
{
    #[Route('/back-office/form', name: 'app_form_list')]
    public function list(FormRepository $formRepository): Response
    {
        return $this->render('form/index.html.twig', [
            'forms' => $formRepository->findBy([], ['id' => 'DESC']),
        ]);
    }
}
