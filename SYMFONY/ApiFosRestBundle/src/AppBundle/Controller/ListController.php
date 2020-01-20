<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\TaskList;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class ListController extends FOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getListsAction()
    {
        $data = $this->entityManager->getRepository(TaskList::class)->findAll();
        return $this->view($data, Response::HTTP_OK);
    }

    public function getListAction(TaskList $taskList)
    {
        return $this->view($taskList, Response::HTTP_OK);
    }

    /**
     * @Rest\RequestParam(name="title",description="Title of the list",nullable=false)
     * @param ParamFetcher $fetcher
     * @return \FOS\RestBundle\View\View
     */
    public function postListsAction(ParamFetcher $fetcher)
    {
        $title = $fetcher->get('title');

        if (!empty(trim($title))) {
            $list = new TaskList();
            $list->setTitle($title);
            $this->entityManager->persist($list);
            $this->entityManager->flush();

            return $this->view($list, Response::HTTP_CREATED);

        }
        return $this->view(['error' => 'the title cannot be null'], Response::HTTP_BAD_REQUEST);

    }

    /**
     * @Rest\RequestParam(name="title",description="the title of the task",nullable=false)
     * @param ParamFetcher $paramFetcher
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function postListTaskActions(ParamFetcher $paramFetcher, int $id)
    {
        $errors = [];
        $taskList = $this->entityManager->getRepository(TaskList::class)->find($id);
        if ($taskList) {
            $title = trim($paramFetcher->get('title'));
            if (!empty($title)) {
                $task = (new Task())
                    ->setTitle($title)
                    ->setTasklist($taskList);
                $taskList->addTask($task);

                $this->entityManager->persist($task);
                $this->entityManager->flush();

                return $this->view($task, Response::HTTP_OK);

            } else {
                $errors[] = ['error' => 'The title cannot be empty'];
            }

        } else {
            $errors[] = ['error' => 'List Not Found'];
        }

        return $this->view($errors, Response::HTTP_BAD_REQUEST);
    }

    public function getListsTasksAction(int $id)
    {
        $taskList = $this->entityManager->getRepository(TaskList::class)->find($id);
        return $this->view($taskList->getTasks(), Response::HTTP_OK);
    }

    public function deleteListAction(int $id)
    {
        $taskList = $this->entityManager->getRepository(TaskList::class)->find($id);
        if (is_null($taskList)) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($taskList);
        $this->entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Rest\RequestParam(name="title",description="the title of the list",nullable=false)
     * @param ParamFetcher $fetcher
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function putListTitleAction(ParamFetcher $fetcher, int $id)
    {
        $errors = [];
        $taskList = $this->entityManager->getRepository(TaskList::class)->find($id);
        if ($taskList) {
            $title = $fetcher->get('title');
            if (!empty(trim($title))) {
                $taskList->setTitle($title);
                $this->entityManager->flush();

                return $this->view(null, Response::HTTP_OK);

            } else {
                $errors[] = [
                    'title' => 'This value cannot be empty'
                ];
            }
        } else {
            $errors[] = [
                'List' => 'The list not found'
            ];
        }

        return $this->view($errors, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\FileParam(
     *     name="image",description="The background of the list",nullable=false,image=true
     * )
     * @param Request $request
     * @param ParamFetcher $fetcher
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function putListsBackgroundAction(Request $request, ParamFetcher $fetcher, int $id)
    {
        $taskList = $this->entityManager->getRepository(TaskList::class)->find($id);
        $currentBackground = $taskList->getBackground();
        if (file_exists($this->getUploadsDir() . $currentBackground)) {
            $fileSystem = new Filesystem();
            $fileSystem->remove($this->getUploadsDir() . $currentBackground);
        }
        /** @var UploadedFile $file */
        $file = $fetcher->get('image');
        if ($file) {
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move($this->getUploadsDir(), $filename);

            $taskList->setBackground($filename);
            $taskList->setBackgroundPath('/uploads/images/' . $filename);
            $this->entityManager->flush();

            $data = $request->getUriForPath($taskList->getBackgroundPath());

            return $this->view($data, Response::HTTP_OK);
        }

        return $this->view(['message' => 'something went wrong'], Response::HTTP_BAD_REQUEST);
    }

    public function getUploadsDir()
    {
        return $this->getParameter('uploads_dir');

        //return '/var/www/html/SymfonyApi/web/uploads/images/';
    }

}
