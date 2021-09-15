<?php

namespace HIshak\OrsLaravelApi;

use InvalidArgumentException;

class OpenRouteGeocoding extends OpenRouteService
{
     /**
     * Forward Geocode Service (GET)
     * @version v2 
     * @author h-ishak
     * Returns a JSON formatted list of objects corresponding to the search input
     *
     * @param string $text  Name of location, street address or postal code. 
     * @param string $options all other optional params as described in the ORS documentation "https://openrouteservice.org/dev/#/api-docs/geocode/search/get"
     * 
     * @return string $response Json format 
     * @throws InvalidArgumentException if the required params are missing
     */
    public function searchGeocode(string $text, array $options = []): string
    {
        if (!empty($text)) {
            $options['text'] = $text;

            $url = "/v2/directions/geocode/search";
            return $this->sendRequest($url, "GET", $options);
        }
        throw new InvalidArgumentException("text is required");
    }

     /**
     * Geocode Autocomplete Service (GET)
     * @version v2 
     * @author h-ishak
     * Autocomplete the input and Returns all possible hits as a JSON formatted list of objects corresponding to the search input
     *
     * @param string $text  Name of location, street address or postal code. 
     * @param string $options all other optional params as described in the ORS documentation "https://openrouteservice.org/dev/#/api-docs/geocode/autocomplete/get"
     * 
     * @return string $response Json format 
     * @throws InvalidArgumentException if the required params are missing
     */
    public function autocompleteGeocode(string $text, array $options = []): string
    {
        if (!empty($text)) {
            $options['text'] = $text;

            $url = "/v2/directions/geocode/autocomplete";
            return $this->sendRequest($url, "GET", $options);
        }
        throw new InvalidArgumentException("text is missing");
    }

    /**
     * Reverse Geocode Service (GET)
     * @version v2 
     * @author h-ishak
     * Returns the next enclosing object with an address tag which surrounds the given coordinate
     *
     * @param string $longitude  Longitude of the coordinate to query. 
     * @param string $latitude  Latitude of the coordinate to query.
     * @param string $options all other optional params as described in the ORS documentation "https://openrouteservice.org/dev/#/api-docs/geocode/reverse/get"
     * 
     * @return string $response Json format 
     * @throws InvalidArgumentException if the required params are missing
     */
    public function reverseGeocode(float $longitude, float $latitude, array $options = []): string
    {
        if (is_float($longitude) && is_float($latitude)) {
            $options['latitude'] = $latitude;
            $options['longitude'] = $longitude;

            $url = "/v2/directions/geocode/autocomplete";
            return $this->sendRequest($url, "GET", $options);
        }
        throw new InvalidArgumentException("longitude and/or latitude are missing");
    }
}