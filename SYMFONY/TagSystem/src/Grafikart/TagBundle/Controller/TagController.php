<?php

namespace Grafikart\TagBundle\Controller;

use Grafikart\TagBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TagController extends Controller
{
    public function indexAction()
    {
        /*$data = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        $data = $this->get('serializer')->serialize($data,'json',['groups' => ['public']]);
        return new Response($data,200,['Content-Type' => 'application/json']);*/

        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        return $this->json($tags, 200, [], ['groups' => ['public']]);
    }
}
