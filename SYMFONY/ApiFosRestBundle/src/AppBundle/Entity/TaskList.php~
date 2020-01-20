<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Task
 *
 * @ORM\Table(name="tasklist")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskListRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TaskList
{
    use Timestamps;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Task",mappedBy="tasklist",orphanRemoval=true)
     */
    private $tasks;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="background", type="string", length=255,nullable=true)
     */
    private $background;

    /**
     * @var string
     *
     * @ORM\Column(name="backgroundPath", type="string", length=255,nullable=true)
     */
    private $backgroundPath;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set background
     *
     * @param string $background
     *
     * @return Task
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set backgroundPath
     *
     * @param string $backgroundPath
     *
     * @return Task
     */
    public function setBackgroundPath($backgroundPath)
    {
        $this->backgroundPath = $backgroundPath;

        return $this;
    }

    /**
     * Get backgroundPath
     *
     * @return string
     */
    public function getBackgroundPath()
    {
        return $this->backgroundPath;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add task
     *
     * @param \AppBundle\Entity\Task $task
     *
     * @return TaskList
     */
    public function addTask(\AppBundle\Entity\Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \AppBundle\Entity\Task $task
     */
    public function removeTask(\AppBundle\Entity\Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return TaskList
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return TaskList
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
}
