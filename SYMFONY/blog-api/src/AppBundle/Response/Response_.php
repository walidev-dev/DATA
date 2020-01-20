<?php

namespace AppBundle\Response;

use Doctrine\DBAL\Schema\View;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class Response_
{
    private $jms_serializer;

    private $entityManager;

    private $validator;

    public function __construct(Serializer $serializer, EntityManager $entityManager, $validator)
    {
        $this->jms_serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function response_serialize($var)
    {
        $data = $this->jms_serializer->serialize($var, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function response_deserialize($request_content, $type)
    {
        $object = $this->jms_serializer->deserialize($request_content, $type, 'json');
        $errors = $this->validator->validate($object);
        if (count($errors)) {
            return new Response($errors, Response::HTTP_BAD_REQUEST);
        }
        $this->entityManager->persist($object);
        $this->entityManager->flush($object);
        return new Response('', Response::HTTP_CREATED);
    }

}