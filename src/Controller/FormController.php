<?php

namespace App\Controller;

use App\Entity\Form;
use App\Form\FormType;
use App\Repository\FormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FormController extends AbstractController
{
    #[Route('/back-office/form/all', name: 'app_form_list')]
    public function list(FormRepository $formRepository): Response
    {
        return $this->render('form/index.html.twig', [
            'forms' => $formRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/back-office/form/create', name: 'app_form_create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request, ValidatorInterface $validator): Response
    {
        $googleForm = new Form();
        $form = $this->createForm(FormType::class, $googleForm);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($googleForm);
            if (count($errors) > 0) {
                return $this->render('form/create.html.twig', [
                    'form' => $form,
                    'errors' => $errors,
                ]);
            }

            $entityManager->persist($googleForm);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_form_list');
        }

        return $this->render('form/create.html.twig', [
            'form' => $form
        ]);
    }
}
