<?php
namespace HIshak\OrsLaravelApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use HIshak\OrsLaravelApi\Exceptions\ForbiddenException;
use HIshak\OrsLaravelApi\Exceptions\FunctionalityUnsupportedException;
use HIshak\OrsLaravelApi\Exceptions\IncorrectException;
use HIshak\OrsLaravelApi\Exceptions\NotFoundException;
use HIshak\OrsLaravelApi\Exceptions\RequestExceededException;
use HIshak\OrsLaravelApi\Exceptions\ServerUnavailableException;
use HIshak\OrsLaravelApi\Exceptions\UnauthorizedException;
use HIshak\OrsLaravelApi\Exceptions\UnexpectedException;
use HIshak\OrsLaravelApi\Exceptions\UnSupportedMethodException;
use ReflectionClass;


abstract class OpenRouteService
{
    const PROFIL_DRIVING_CAR = "driving-car";
    const PROFIL_DRIVING_HGV = "driving-hgv";
    const PROFIL_CYCLING_HGV = "cycling-hgv";
    const PROFIL_CYCLING_REGULAR = "cycling-regular";
    const PROFIL_CYCLING_ROAD = "cycling-road";
    const PROFIL_CYCLING_MOUNTAIN = "cycling-mountain";
    const PROFIL_CYCLING_ELETRIC = "cycling-electric";
    const PROFIL_FOOT_WALKING = "foot-walking";
    const PROFIL_FOOT_HIKING = "foot-hiking";
    const PROFIL_WHEELCHAIR = "wheelchair";

    private $api_key;
    private $base_url = "https://api.openrouteservice.org";
    private $base_headers = [
        "Accept" => "application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
        "Content-Type" => "application/json; charset=utf-8"
    ];

    public function __construct()
    {
        $this->api_key =  env('ORS_API_KEY', null);
    }


    protected static function getConstants() {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }


    protected function sendRequest($endpoint,$method,$params = [])
    {
        $url = $this->base_url;
        $headers = $this->base_headers;
        if(strtolower($method) == "get")
        {
            $buffUrl = $endpoint . "?api_key=" . $this->api_key;
            
            foreach($params as $paramName => $paramValue)
                $buffUrl .= "&" . $paramName . "=" . $paramValue;
            $url .= $buffUrl; 
        }  
        else 
        {    
            $url .= $endpoint;
            $headers['Authorization'] = $this->api_key;
        }
        
        //creating a client instance
        $client = new Client(['timeout'  => 5.0]);

        try
        {
            //sending a request
            $request = new Request($method, $url,$headers,json_encode($params));
            $response = $client->send($request, ['timeout' => 2]);

            if($response && $response->getStatusCode() == "200")
                return $response->getBody();
        }
        catch(BadResponseException  $e){
            switch ($e->getResponse()->getStatusCode()) {
                case '400':
                    throw new IncorrectException();
                    break;
                case '401':
                    throw new UnauthorizedException();
                    break;
                case '403':
                    throw new ForbiddenException();
                    break;
                case '404':
                    throw new NotFoundException();
                    break;
                case '405':
                    throw new UnSupportedMethodException();
                    break;
                case '413':
                    throw new RequestExceededException();
                    break;
                case '500':
                    throw new UnexpectedException();
                    break;
                case '501':
                    throw new FunctionalityUnsupportedException();
                    break;
                case '503':
                    throw new ServerUnavailableException();
                    break;
            }

        }
    }

}