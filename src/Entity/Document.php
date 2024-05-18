<?php

namespace App\Entity;

use App\Constant\Message;
use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type(
        type: 'string',
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Regex(
        pattern: "/^[\\s\\p{Ll}\\p{Lu}\\p{M}\\-']+$/iu",
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type(
        type: 'string',
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Regex(
        pattern: "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\(\\)\\/\\+=]+$/iu",
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    private ?string $path = null;

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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }
}
