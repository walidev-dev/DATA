<?php
namespace AppBundle\Weather;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;

class Weather{

    private $weatherClient;
    private $serializer;
    private $apiKey;

    public function __construct(Client $client,Serializer $serializer,$apiKey){
        $this->weatherClient=$client;
        $this->serializer=$serializer;
        $this->apiKey=$apiKey;
    }

    public function getCurrent(){
        $uri='/data/2.5/weather?APPID='.$this->apiKey.'&q=casablanca&units=metric';
        $response=$this->weatherClient->get($uri);
        $data=$this->serializer->deserialize($response->getBody(),'array','json');
        return [
            'city'=>$data['name'],
            'description'=>$data['weather'][0]['main'],
            'temperature'=>$data['main']['temp']
        ];
    }
}