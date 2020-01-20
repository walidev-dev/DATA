<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends Controller
{

    public function indexAction(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Property::class);
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig',compact('properties'));
    }
}
