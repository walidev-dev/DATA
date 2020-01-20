<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PageController extends Controller
{
    /**
     * @Route("/hello", name="page")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/auth",name="auth")
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function AuthAction(AuthorizationCheckerInterface $authorizationChecker)
    {
//        if (!$authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
//            $this->redirectToRoute('login');
//        }
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function AdminAction()
    {
        return new Response("Page réservé à Admin");
    }

    /**
     * @Route("/mail", name="mail")
     *
     * @param \Swift_Mailer $mailer
     */
    public function mailAction(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello', 'Hello'))
            ->setTo('contact@admin.fr')
            ->setFrom('noreply@domain.fr');
        $mailer->send($message);

    }
}
