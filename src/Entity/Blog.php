<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestamps;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\BlogRepository")
 */
class Blog
{
    use Timestamps;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=55)
     * @ORM\Column(type="string", length=55)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=400)
     * @ORM\Column(type="string", length=400)
     */
    private $shortContent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default" : false})
     */
    private $isDraft;

    /**
     * Check whether content == null
     *
     * @return void
     *
     * @ORM\PrePersist
     */
    public function checkContent(): void
    {
        if (null === $this->getContent()) {
            $this->isDraft = false;
        }
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get isDraft flag
     *
     * @return int
     */
    public function getIsDraft()
    {
        return $this->isDraft;
    }

    /**
     * Set isDraft flag
     *
     * @param bool $value 
     * 
     * @return void
     */
    public function setIsDraft(bool $value): void
    {
        $this->isDraft = $value;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getShortContent(): ?string
    {
        return $this->shortContent;
    }

    public function setShortContent(string $shortContent): self
    {
        $this->shortContent = $shortContent;

        return $this;
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
}
