<?php
namespace ishak\OpenRouteService;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use ReflectionClass;
use Throwable;

class OpenRouteService
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


    private static function getConstants() {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    

    /**
     * Directions Service (GET)
     * @version v2 
     * @author h-ishak
     * Get a basic route between two points with the profile provided. 
     * Returned response is in GeoJSON format. 
     * This method does not accept any request body or parameters other than profile, start coordinate, and end coordinate.
     *
     * @param string $profil Destination coordinate of the route 
     * @param string $start Start coordinate of the route
     * @param string $end Destination coordinate of the route
     * 
     * @return json $response
     */
    public function getDirections($profil,$start,$end)
    {
        if(in_array($profil,self::getConstants()))
        {
            $url = "/v2/directions/" . $profil;
            return $this->sendRequest($url,"GET",["start" => $start,"end" => $end]); 
        }
        return "Profile Doesn't exists";
    }


    /**
     * Directions Service (POST)
     * @version v2 
     * @author h-ishak
     * Returns a route between two or more locations for a selected profile and its settings as GeoJSON
     *
     * @param string $profil Destination coordinate of the route 
     * @param array $coordinates The waypoints to use for the route as an array of longitude/latitude pairs
     * @param string $options all other optional params as described in the ORS documentation "https://openrouteservice.org/dev/#/api-docs/v2/directions/{profile}/geojson/post"
     * 
     * @return GeoJSON $response
     */
    public function getDirectionsWithGeoJson($profil,$coordinates,$options = [])
    {
        if(in_array($profil,self::getConstants()) && is_array(current($coordinates)))
        {
            $options['coordinates'] = $coordinates;
            
            $url = "/v2/directions/" . $profil ."/geojson";
            return $this->sendRequest($url,"POST",$options); 
        }
        return "Profile Doesn't exists";
    }

    /**
     * Directions Service (POST)
     * @version v2 
     * @author h-ishak
     * Returns a route between two or more locations for a selected profile and its settings as JSON
     *
     * @param string $profil Destination coordinate of the route 
     * @param array $coordinates The waypoints to use for the route as an array of longitude/latitude pairs
     * @param string $options all other optional params as described in the ORS documentation "https://openrouteservice.org/dev/#/api-docs/v2/directions/{profile}/post"
     * 
     * @return json $response
     */
    public function getDirectionsWithSettings($profil,$coordinates,$options = [])
    {
        if(in_array($profil,self::getConstants()) && is_array(current($coordinates)))
        {
            $options['coordinates'] = $coordinates;
            
            $url = "/v2/directions/" . $profil;
            return $this->sendRequest($url,"POST",$options); 
        }
        return "Profile Doesn't exists";
    }

     /**
     * Directions Service (POST)
     * @version v2 
     * @author h-ishak
     * Returns a route between two or more locations for a selected profile and its settings as GPX. The schema can be found in
     * "https://raw.githubusercontent.com/GIScience/openrouteservice-schema/master/gpx/v1/ors-gpx.xsd"
     *
     * @param string $profil Destination coordinate of the route 
     * @param array $coordinates The waypoints to use for the route as an array of longitude/latitude pairs
     * @param string $options all other optional params as described in the ORS documentation "https://openrouteservice.org/dev/#/api-docs/v2/directions/{profile}/gpx/post"
     * 
     * @return gpxRouteElements $response
     */
    public function getDirectionsWithGpx($profil,$coordinates,$options = [])
    {
        if(in_array($profil,self::getConstants()) && is_array(current($coordinates)))
        {
            $options['coordinates'] = $coordinates;
            
            $url = "/v2/directions/" . $profil . "/gpx";
            return $this->sendRequest($url,"POST",$options); 
        }
        return "Profile Doesn't exists";
    }





    private function sendRequest($endpoint,$method,$params = [])
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
        catch(Throwable $e){
            dd($e);
        }
        return null;
    }
}