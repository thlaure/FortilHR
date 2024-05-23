<?php

namespace App\Form;

use App\Constant\Constraint;
use App\Constant\Message;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Contracts\Translation\TranslatorInterface;

class EventType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => $this->translator->trans('name'),
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => $this->translator->trans('start_date'),
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => $this->translator->trans('end_date'),
            ])
            ->add('program', TextareaType::class, [
                'label' => $this->translator->trans('program'),
            ])
            ->add('image', FileType::class, [
                'label' => $this->translator->trans('image'),
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => Constraint::IMAGE_MAX_FILE_SIZE,
                        'mimeTypes' => Constraint::IMAGE_ALLOWED_MIME_TYPES,
                        'maxSizeMessage' => Message::GENERIC_FILE_FORM_ERROR,
                        'mimeTypesMessage' => Message::GENERIC_FILE_FORM_ERROR,
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'submit',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
