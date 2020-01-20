<?php
namespace OC\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    public function loginAction(){
        if($this->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            return $this->RedirectToRoute('oc_platform_home');
        }
        $authenticationUtils=$this->get('security.authentication_utils');
        return $this->render("UserBundle:Security:login.html.twig",[
            'last_username'=>$authenticationUtils->getLastUsername(),
            'error'=>$authenticationUtils->getLastAuthenticationError()
        ]);
    }

}