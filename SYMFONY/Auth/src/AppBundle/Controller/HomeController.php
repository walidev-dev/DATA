<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class HomeController extends Controller
{
    public function indexAction(AuthorizationCheckerInterface $authorizationChecker)
    {
        if ($authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->render('home/home_admin.html.twig');
        } else if ($authorizationChecker->isGranted('ROLE_USER')) {
            return $this->render('home/home_user.html.twig');
        }
    }

}
