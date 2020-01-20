<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/new", name="post_create")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(
        Request $request,
        EntityManagerInterface $entityManager
    )
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('post_index');
        }
        return $this->render('default/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/index",name="post_index")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function indexAction(
        EntityManagerInterface $entityManager
    )
    {
        $posts = $entityManager->getRepository(Post::class)->getAll();
        return $this->render('default/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/edit/{id}",name="post_edit")
     *
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function editAction(
        int $id,
        EntityManagerInterface $entityManager,
        Request $request
    )
    {
        $post = $entityManager->getRepository(Post::class)->getOne($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('post_index');
        }
        return $this->render('default/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/remove/{id}",name="post_remove")
     *
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function removeAction(
        int $id,
        EntityManagerInterface $entityManager,
        Request $request
    )
    {
        $post = $entityManager->getRepository(Post::class)->getOne($id);
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
            return $this->redirectToRoute('post_index');
        }
    }
}
