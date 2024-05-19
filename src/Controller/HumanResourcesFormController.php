<?php

namespace App\Controller;

use App\Constant\Message;
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
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale}', name: 'app_hrform_', locale: 'fr')]

class HumanResourcesFormController extends AbstractController
{
    public function __construct(private LoggerInterface $logger, private TranslatorInterface $translator)
    {
    }

    #[Route('/back-office/form/list', name: 'list')]
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

    #[Route('/back-office/form/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager, Request $request, ValidatorInterface $validator): Response
    {
        $hrForm = new HumanResourcesForm();
        $form = $this->createForm(HumanResourcesFormType::class, $hrForm);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $errors = $validator->validate($hrForm);
            if (count($errors) > 0) {
                $this->addFlash('error', $this->translator->trans($errors[0]->getMessage()));

                return $this->redirectToRoute('app_hrform_create');
            }

            if ($form->isValid()) {
                try {
                    $entityManager->persist($hrForm);
                    $entityManager->flush();
    
                    $this->addFlash('success', $this->translator->trans(Message::GENERIC_SUCCESS));
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                    $this->addFlash('error', $this->translator->trans(Message::GENERIC_ERROR));
                }

                return $this->redirectToRoute('app_hrform_list');
            }
        }

        return $this->render('hr_form/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/back-office/form/{id}/delete', name: 'delete')]
    public function delete(HumanResourcesForm $hrForm, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($hrForm);
            $entityManager->flush();

            $this->addFlash('success', $this->translator->trans(Message::GENERIC_SUCCESS));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $this->addFlash('error', $this->translator->trans(Message::GENERIC_ERROR));
        }

        return $this->redirectToRoute('app_hrform_list');
    }

    #[Route('/back-office/form/{id}/edit', name: 'edit')]
    public function edit(HumanResourcesForm $hrForm, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(HumanResourcesFormType::class, $hrForm);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $errors = $validator->validate($hrForm);
            if (count($errors) > 0) {
                $this->addFlash('error', $this->translator->trans($errors[0]->getMessage()));

                return $this->redirectToRoute('app_hrform_edit', ['id' => $hrForm->getId()]);
            }

            if ($form->isValid()) {
                try {
                    $entityManager->flush();
                    
                    $this->addFlash('success', $this->translator->trans(Message::GENERIC_SUCCESS));
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                    $this->addFlash('error', $this->translator->trans(Message::GENERIC_ERROR));
                }

                return $this->redirectToRoute('app_hrform_list');
            }
        }

        return $this->render('hr_form/create.html.twig', [
            'form' => $form
        ]);
    }
}
