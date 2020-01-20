<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends FOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getNoteAction(Note $note)
    {
        return $this->view($note, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteNoteAction(int $id)
    {
        $note = $this->entityManager->getRepository(Note::class)->find($id);
        if ($note) {
            $this->entityManager->remove($note);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view(['message' => 'something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
