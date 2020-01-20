<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(
        AuthorizationCheckerInterface $authorizationChecker,
        AuthenticationUtils $authenticationUtils
    )
    {
        if ($authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('auth');
        }

        return $this->render('security/login.html.twig', [
            'username' => $authenticationUtils->getLastUsername(),
            'errors' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
}
