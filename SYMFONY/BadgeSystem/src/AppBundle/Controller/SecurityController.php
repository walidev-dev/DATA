<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function loginAction(): Response
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $errors = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            'errors' => $errors,
            'lastUsername' => $lastUsername
        ]);
    }
}
