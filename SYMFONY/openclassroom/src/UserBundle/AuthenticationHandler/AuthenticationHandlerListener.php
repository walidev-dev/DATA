<?php

namespace UserBundle\AuthenticationHandler;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class AuthenticationHandlerListener implements
    AuthenticationSuccessHandlerInterface,
    AuthenticationFailureHandlerInterface
{
    /**
     * @var FlashBagInterface $flashBag
     */
    private $flashBag;
    /**
     * @var RouterInterface $router
     */
    private $router;

    /**
     * AuthenticationSuccessHandler constructor.
     * @param FlashBagInterface $flashBag
     * @param RouterInterface $router
     */
    public function __construct(FlashBagInterface $flashBag, RouterInterface $router)
    {
        $this->flashBag = $flashBag;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $this->flashBag->add('notice', 'Vous vous Êtes connecté avec succés.');
        return new RedirectResponse($this->router->generate('app_platform_home'));
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $this->flashBag->add('error_login', "Erreur de connexion, Merci de verifier vos identifiants.");
        return new RedirectResponse($this->router->generate('login'));
    }

  /*  public function onLogoutSuccess(Request $request)
    {

    }*/
}