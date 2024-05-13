<?php

namespace App\Controller;

use App\Entity\HumanResourcesForm;
use App\Form\HumanResourcesFormType;
use App\Repository\HumanResourcesFormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HumanResourcesFormController extends AbstractController
{
    #[Route('/back-office/form/all', name: 'app_hrform_list')]
    public function list(HumanResourcesFormRepository $hrFormRepository): Response
    {
        return $this->render('hr_form/list.html.twig', [
            'hr_forms' => $hrFormRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/back-office/form/create', name: 'app_hrform_create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request, ValidatorInterface $validator): Response
    {
        $hrForm = new HumanResourcesForm();
        $form = $this->createForm(HumanResourcesFormType::class, $hrForm);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($form);
            if (count($errors) > 0) {
                return $this->render('hr_form/create.html.twig', [
                    'form' => $form,
                    'errors' => $errors,
                ]);
            }

            $entityManager->persist($hrForm);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_hrform_list');
        }

        return $this->render('hr_form/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/back-office/form/{id}/delete', name: 'app_hrform_delete')]
    public function delete(HumanResourcesForm $hrForm, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($hrForm);
        $entityManager->flush();

        return $this->redirectToRoute('app_hrform_list');
    }
}
