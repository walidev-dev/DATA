<?php

namespace AppBundle\Validator;


use AppBundle\Entity\Advert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AntifloodValidator extends ConstraintValidator
{
    private $requestStack;
    private $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function validate($value, Constraint $constraint)
    {
        $request = $this->requestStack->getCurrentRequest();
        $ip = $request->getClientIp();
        $isFlood = $this->entityManager->getRepository(Advert::class)->isFlood($ip, 15);
        if ($isFlood) {
            $this->context->addViolation($constraint->message);
        }
    }
}