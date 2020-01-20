<?php

namespace AppBundle\Controller;

use Doctrine\DBAL\Schema\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\Tests\Fixtures\Author;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Article;
use GuzzleHttp\Client;

class ArticleController extends Controller
{
    /**
     * @Rest\Get("/articles/")
     * @Rest\View
     */
    public function listAction()
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->findAll();
        if ($articles === null) {
            return new View("y a pas d'articles !", Response::HTTP_NOT_FOUND);
        }
        return $articles;
    }


    /**
     * @Rest\Get(
     *     path = "/articles/{id}",
     *     name = "app_article_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function showAction(Article $article)
    {
        return $article;
    }


//    /**
//     *  @Route("/articles/{id}",name="article_show")
//     */
//    public function showAction(Article $article){
////        $repository=$this->getDoctrine()->getRepository("AppBundle:Article");
////        $article=$repository->find($id);
//        return $this->get('response.response_')->response_serialize($article);
//    }

    /**
     * @Route("/articles",name="article_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $data = $request->getContent();
        return $this->get('response_')->response_deserialize($data, 'AppBundle\Entity\Article');
    }

//    /**
//     * @Route("/articles/",name="article_list")
//     * @Method({"GET"})
//     */
//    public function listAction(){
//        $repository=$this->getDoctrine()->getRepository("AppBundle:Article");
//        $articles=$repository->findAll();
//        return $this->get('response_')->response_serialize($articles);
//    }

    /**
     * @Route("/test")
     * @Method({"GET"})
     */
    public function testAction()
    {
//        $repository=$this->getDoctrine()->getRepository( 'AppBundle:Article');
//        $articles=$repository->getArticles();
//        $response=new Response(json_encode($articles));
//        $response->headers->set('Content-Type','application/json');
//        return $response;

        //WEATHER API

//        $appKey = $this->container->getParameter('weather_api_key');
//        $city = 'Casablanca';
//        $client = new Client();
//        $res = $client->request('GET', 'http://api.openweathermap.org/data/2.5/weather?q=' .
//            $city . '&mode=json&units=metric&APPID=' .
//            $appKey
//        );
//        $data = $this->get('jms_serializer')->deserialize($res->getBody(), 'array', 'json');
//        dump($data);
//        $a = [
//            'city' => $data['name'],
//            'description' => $data['weather'][0]['main'],
//            'temperature' => $data['main']['temp']
//        ];
//        dump($a);
//        die();

        //GOOGLE MAP API

        $mapKey = $this->container->getParameter('google_map_key');
        $latlng = "33.58932, -7.64031";
        $client = $this->get('guzzle_client');
        //$uri="/maps/api/geocode/json?latlng=".$latlng."&key=".$mapKey;
        $uri = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latlng . "&key=" . $mapKey;
        $response = $client->get($uri);
        $data = $this->get('jms_serializer')->deserialize($response->getBody(), 'array', 'json');
        dump($data['results'][0]['formatted_address']);
        die();
    }
}