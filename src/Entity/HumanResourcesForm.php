<?php

namespace App\Entity;

use App\Constant\Constraint;
use App\Constant\Message;
use App\Repository\HumanResourcesFormRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HumanResourcesFormRepository::class)]
class HumanResourcesForm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: Message::GENERIC_ENTITY_FIELD_ERROR)]
    #[Assert\Type(
        type: 'string',
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Regex(
        pattern: Constraint::REGEX_TITLE,
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: Message::GENERIC_ENTITY_FIELD_ERROR)]
    #[Assert\Url(message: Message::GENERIC_ENTITY_FIELD_ERROR)]
    #[Assert\Length(max: 255, maxMessage: Message::GENERIC_ENTITY_FIELD_ERROR)]
    private ?string $link = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }
}
