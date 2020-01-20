<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class CommentController extends Controller
{
    /**
     * @Route("/create",name="comment_create")
     * @return Response
     */
    public function newAction(Request $request): Response
    {
        /*$connection = $this->getDoctrine()->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('comment', true));
        $connection->executeUpdate($platform->getTruncateTableSQL('badge_unlock', true));
        exit();*/

        $em = $this->getDoctrine()->getManager();
        $badgeManager = $this->get('badge_manager');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $comment = new Comment();
        $comment->setUser($user);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->getConnection()->beginTransaction();
            $em->flush();

            //DEBLOCAGE DU BADGE

            $commentsCount = $em->getRepository(Comment::class)->countForUser($user->getId());
            $badgeManager->checkAndUnlock($user, 'comment', $commentsCount);
            $em->getConnection()->commit();

        }
        $comments = $em->getRepository(Comment::class)->getAll();
        $badges = $badgeManager->getBadgesForUser($user);
        return $this->render('comment/new.html.twig', [
            'form' => $form->createView(),
            'comments' => $comments,
            'badges' => $badges
        ]);
    }
}
