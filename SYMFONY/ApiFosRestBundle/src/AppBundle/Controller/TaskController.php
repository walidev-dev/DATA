<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends FOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getTaskNotesAction(int $id)
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);
        if ($task) {
            return $this->view($task->getNotes(), Response::HTTP_OK);
        }

        return $this->view(['message' => 'something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    /**
     * @Rest\RequestParam(name="title",description="the title of the task",nullable=false)
     * @param ParamFetcher $paramFetcher
     * @return \FOS\RestBundle\View\View
     */
    public function postTaskAction(ParamFetcher $paramFetcher)
    {
        $title = trim($paramFetcher->get('title'));
        if (!empty($title)) {
            $task = (new Task())->setTitle($title);
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            return $this->view($task, Response::HTTP_CREATED);
        }

        return $this->view(['error' => 'The title cannot be null'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteTaskAction(int $id)
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return $this->view(['message' => 'Item removed'], Response::HTTP_NO_CONTENT);
    }

    public function getTasksAction()
    {
        $tasks = $this->entityManager->getRepository(Task::class)->findAll();

        return $this->view($tasks, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function getTaskAction(int $id)
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);

        return $this->view($task, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function putTaskIscompleteAction(int $id)
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);
        if ($task) {
            $task->setIsComplete(true);
            $this->entityManager->flush();

            return $this->view($task, Response::HTTP_OK);
        }

        return $this->view(['message' => 'something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Rest\RequestParam(name="content",description="the content of the note",nullable=false)
     * @param ParamFetcher $paramFetcher
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function postTaskNoteAction(ParamFetcher $paramFetcher, int $id)
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);
        if ($task) {
            $content = trim($paramFetcher->get('content'));
            if (!empty($content)) {
                $note = (new Note())
                    ->setContent($content)
                    ->setTask($task);

                $task->addNote($note);

                $this->entityManager->persist($note);
                $this->entityManager->flush();

                return $this->view($note, Response::HTTP_CREATED);
            }

            return $this->view(['message' => 'the content cannot be empty'], Response::HTTP_BAD_REQUEST);
        }

        return $this->view(['message' => 'Task Not Found'], Response::HTTP_NOT_FOUND);
    }
}
