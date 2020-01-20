<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function loginAction(
        AuthenticationUtils $authenticationUtils
    )
    {
        return $this->render('admin/login.html.twig', [
            'username' => $authenticationUtils->getLastUsername(),
            'errors' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
}
