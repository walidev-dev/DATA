<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as Route;
use FOS\RestBundle\Context\Context;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends FOSRestController
{
    /**
     * @Route("/register",name="register",methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @return \FOS\RestBundle\View\View
     */
    public function registerAction(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $encoder
    )
    {
        $username = trim($request->get('username'));
        $password = trim($request->get('password'));
        if (empty($username) || empty($password)) {
            return $this->view(['message' => 'Fields cannot be empty'], Response::HTTP_BAD_REQUEST);
        }

        $user = $entityManager->getRepository(User::class)->findOneBy([
            'username' => $username
        ]);

        if (!is_null($user)) {
            return $this->view(['message' => 'User already exists'], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setRoles(["ROLE_USER"]);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->view($user, Response::HTTP_CREATED)->setContext((new Context())->setGroups(['public']));
    }
}
