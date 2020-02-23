<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminActionRepository")
 */
class AdminAction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="adminActions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $performedBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $performedAt;

    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $details;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerformedBy(): ?User
    {
        return $this->performedBy;
    }

    public function setPerformedBy(?User $performedBy): self
    {
        $this->performedBy = $performedBy;

        return $this;
    }

    public function getPerformedAt(): ?\DateTimeInterface
    {
        return $this->performedAt;
    }

    public function setPerformedAt(\DateTimeInterface $performedAt): self
    {
        $this->performedAt = $performedAt;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }
}
