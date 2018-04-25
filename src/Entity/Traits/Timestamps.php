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
    private $updated_at;

    /**
     * Date created at
     *
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * Set update at
     *
     * @param \DateTime $value
     *
     * @return void
     */
    public function setUpdatedAt(DateTime $value): void
    {
        $this->updated_at = $value;
    }

    /**
     * Get update at
     *
     * @return DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
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
        $this->created_at = $value;
    }

    /**
     * Get created at
     *
     * @return DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    /**
     * Update timestamps
     * 
     * @return void
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTime('now'));
        }
    }
}
