<?php

namespace App\Entity;

use App\Constant\Message;
use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
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
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type('\DateTimeInterface')]
    #[Assert\GreaterThanOrEqual('today')]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type('\DateTimeInterface')]
    #[Assert\GreaterThanOrEqual('today')]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(
        max: 255,
        maxMessage: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Regex(
        pattern: "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\(\\)\\/\\+=]+$/iu",
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    private ?string $imageName = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Type(
        type: 'string',
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Length(
        max: 2000,
        maxMessage: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Regex(
        pattern: "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\r\n\\(\\)\\/°\\+=]+$/iu",
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]

    private ?string $program = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getProgram(): ?string
    {
        return $this->program;
    }

    public function setProgram(string $program): static
    {
        $this->program = $program;

        return $this;
    }
}
