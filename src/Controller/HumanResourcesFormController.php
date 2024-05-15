<?php

namespace App\Controller;

use App\Entity\HumanResourcesForm;
use App\Exception\DatabaseException;
use App\Form\HumanResourcesFormType;
use App\Repository\HumanResourcesFormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HumanResourcesFormController extends AbstractController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    #[Route('/back-office/form/all', name: 'app_hrform_list')]
    public function list(HumanResourcesFormRepository $hrFormRepository): Response
    {
        try {
            $hrForms = $hrFormRepository->findBy([], ['id' => 'DESC']);

            return $this->render('hr_form/list.html.twig', [
                'hr_forms' => $hrForms,
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new DatabaseException($e->getMessage());
        }
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

            try {
                $entityManager->persist($hrForm);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->addFlash('error', $e->getMessage());
            }
            
            return $this->redirectToRoute('app_hrform_list');
        }

        return $this->render('hr_form/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/back-office/form/{id}/delete', name: 'app_hrform_delete')]
    public function delete(HumanResourcesForm $hrForm, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($hrForm);
            $entityManager->flush();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app_hrform_list');
    }
}
