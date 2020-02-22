<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     * @Groups({"post-info"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5000)
     * 
     * @Groups({"post-info"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({"post-info"})
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({"post-info"})
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups({"post-info"})
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getParent(): ?Question
    {
        return $this->parent;
    }

    public function setParent(?Question $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
