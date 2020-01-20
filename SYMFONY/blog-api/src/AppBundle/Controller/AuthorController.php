<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\View\ViewHandler;
class AuthorController extends Controller
{
    /**
     * @Route("/authors/{id}",name="author_show")
     */
    public function showAction(Author $author){
//        $em=$this->getDoctrine()->getManager();
//        $author=$em->getRepository('AppBundle:Author')->find($id);
        $data=$this->get('jms_serializer')->serialize($author,'json');
        $response=new Response($data);
        $response->headers->set('Content-Type','application/json');
        return $response;
    }

    /**
     * @Rest\Get("/authors",name="author_list")
     */
    public function listAction(){
        $authors=$this->getDoctrine()->getRepository('AppBundle:Author')->findAll();
        $data=$this->get('jms_serializer')->serialize($authors,'json');
        $response=new Response($data);
        $response->headers->set('Content-Type','application/json');
        return $response;
    }

}