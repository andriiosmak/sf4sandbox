<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Trait Timestamps
 * 
 * @package App\Entity\Traits
 */
trait Timestamps
{
    /**
     * Date update at
     *
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Date created at
     *
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Set update at
     *
     * @param \DateTime $value
     *
     * @return void
     */
    public function setUpdatedAt(DateTime $value): void
    {
        $this->updatedAt = $value;
    }

    /**
     * Get update at
     *
     * @return DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set created at
     *
     * @param \DateTime $value
     *
     * @return void
     */
    public function setCreatedAt($value): void
    {
        $this->createdAt = $value;
    }

    /**
     * Get created at
     *
     * @return DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * Update timestamps
     * 
     * @return void
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps(): void
    {
        $this->setUpdatedAt(new DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTime('now'));
        }
    }
}
