<?php

namespace HIshak\OrsLaravelApi;

use InvalidArgumentException;

class OpenRouteDirections extends OpenRouteService
{

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
     * @return string $response Json format 
     * @throws InvalidArgumentException if the required params are missing
     */
    public function getDirections($profil,$start,$end): string
    {
        if (in_array($profil, self::getConstants())) {
            $url = "/v2/directions/" . $profil;
            return $this->sendRequest($url, "GET", ["start" => $start, "end" => $end]);
        }
        throw new InvalidArgumentException('the profil , the start or the end are missing');
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
     * @return string $response GeoJson format
     * @throws InvalidArgumentException if the required params are missing
     */
    public function getDirectionsWithGeoJson($profil, $coordinates, $options = []): string
    {
        if (in_array($profil, self::getConstants()) && is_array(current($coordinates))) {
            $options['coordinates'] = $coordinates;

            $url = "/v2/directions/" . $profil . "/geojson";
            return $this->sendRequest($url, "POST", $options);
        }
        throw new InvalidArgumentException('the profil or the coordinates are missing');
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
     * @return string $response Json format
     * @throws InvalidArgumentException if the required params are missing
     */
    public function getDirectionsWithSettings($profil, $coordinates, $options = []): string
    {
        if (in_array($profil, self::getConstants()) && is_array(current($coordinates))) {
            $options['coordinates'] = $coordinates;

            $url = "/v2/directions/" . $profil;
            return $this->sendRequest($url, "POST", $options);
        }
        throw new InvalidArgumentException('the profil or the coordinates are missing');
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
     * @throws InvalidArgumentException if the required params are missing
     */
    public function getDirectionsWithGpx($profil, $coordinates, $options = [])
    {
        if (in_array($profil, self::getConstants()) && is_array(current($coordinates))) {
            $options['coordinates'] = $coordinates;

            $url = "/v2/directions/" . $profil . "/gpx";
            return $this->sendRequest($url, "POST", $options);
        }
        throw new InvalidArgumentException('the profil or the coordinates are missing');
    }
}
