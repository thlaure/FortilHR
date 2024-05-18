<?php

namespace App\Entity;

use App\Constant\Message;
use App\Entity\Document;
use App\Entity\HumanResourcesForm;
use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
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

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Type(
        type: 'string',
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Length(
        max: 2000,
        axMessage: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    #[Assert\Regex(
        pattern: "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\r\n\\(\\)\\/°\\+=]+$/iu",
        message: Message::GENERIC_ENTITY_FIELD_ERROR
    )]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\DateTime]
    #[Assert\GreaterThanOrEqual('today')]
    private ?\DateTimeInterface $sendDate = null;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\ManyToMany(targetEntity: Document::class)]
    private Collection $documents;

    /**
     * @var Collection<int, HumanResourcesForm>
     */
    #[ORM\ManyToMany(targetEntity: HumanResourcesForm::class)]
    private Collection $forms;

    #[ORM\Column]
    #[Assert\Type('bool')]
    private ?bool $isRead = null;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->forms = new ArrayCollection();
    }

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getSendDate(): ?\DateTimeInterface
    {
        return $this->sendDate;
    }

    public function setSendDate(\DateTimeInterface $sendDate): static
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): static
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        $this->documents->removeElement($document);

        return $this;
    }

    /**
     * @return Collection<int, Form>
     */
    public function getForms(): Collection
    {
        return $this->forms;
    }

    public function addForm(HumanResourcesForm $form): static
    {
        if (!$this->forms->contains($form)) {
            $this->forms->add($form);
        }

        return $this;
    }

    public function removeForm(HumanResourcesForm $form): static
    {
        $this->forms->removeElement($form);

        return $this;
    }

    public function isRead(): ?bool
    {
        return $this->isRead;
    }

    public function setRead(bool $isRead): static
    {
        $this->isRead = $isRead;

        return $this;
    }
}
