<?php

namespace AppBundle\Entity;

trait Timestamps
{

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;


    /**
     * @ORM\PrePersist
     */
    public function initializeDate()
    {
        $this->createdAt = new \DateTime();
        $this->updateAt = new \DateTime();
    }


    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->updateAt = new \DateTime();
    }
}