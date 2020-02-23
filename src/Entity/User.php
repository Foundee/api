<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"user-basic-info"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     * 
     * @Groups({"user-basic-info"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * 
     * @Groups({"mod-user-info"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups({"user-basic-info"})
     */
    private $registerDate;

    /**
     * @ORM\Column(type="string", length=15)
     * 
     * @Groups({"mod-user-info"})
     */
    private $registerIp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="author")
     * 
     * @Groups({"user-detailed-info"})
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="author")
     * 
     * @Groups({"user-detailed-info"})
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ban", mappedBy="user")
     */
    private $bans;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdminAction", mappedBy="performedBy")
     */
    private $adminActions;

    public function __construct()
    {
        $this->registerDate = new DateTime();
        $this->questions = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->bans = new ArrayCollection();
        $this->adminActions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRegisterDate(): DateTime
    {
        return $this->registerDate;
    }

    public function getRegisterIp(): string
    {
        return $this->registerIp;
    }

    public function setRegisterIp(string $registerIp): void
    {
        $this->registerIp = $registerIp;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setAuthor($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getAuthor() === $this) {
                $question->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ban[]
     */
    public function getBans(): Collection
    {
        return $this->bans;
    }

    public function addBan(Ban $ban): self
    {
        if (!$this->bans->contains($ban)) {
            $this->bans[] = $ban;
            $ban->setUser($this);
        }

        return $this;
    }

    public function removeBan(Ban $ban): self
    {
        if ($this->bans->contains($ban)) {
            $this->bans->removeElement($ban);
            // set the owning side to null (unless already changed)
            if ($ban->getUser() === $this) {
                $ban->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AdminAction[]
     */
    public function getAdminActions(): Collection
    {
        return $this->adminActions;
    }

    public function addAdminAction(AdminAction $adminAction): self
    {
        if (!$this->adminActions->contains($adminAction)) {
            $this->adminActions[] = $adminAction;
            $adminAction->setPerformedBy($this);
        }

        return $this;
    }

    public function removeAdminAction(AdminAction $adminAction): self
    {
        if ($this->adminActions->contains($adminAction)) {
            $this->adminActions->removeElement($adminAction);
            // set the owning side to null (unless already changed)
            if ($adminAction->getPerformedBy() === $this) {
                $adminAction->setPerformedBy(null);
            }
        }

        return $this;
    }
}
