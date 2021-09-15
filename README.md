# ors-api-service
a simple Laravel package for the OpenRouteService Api

## Installation, and Usage Instructions

This package allows you to consume OpenRouteService Api using laravel.

```cli
composer require h-ishak/ors-api-service
```
Set  API key in the .env  
```env
ORS_API_KEY = some key
```
Once installed you can do stuff like this:

```php
    $ORS = new OpenRouteService();
    $response = $ORS->getDirectionsWithGpx(OpenRouteService::PROFIL_DRIVING_CAR,[[8.681495,49.41461],[8.687872,49.420318]]);
    return $response;
```

here is a list of the available profiles :
    
| Const | Value |
| --- | --- |
|PROFIL_DRIVING_CAR | "driving-car"|
|PROFIL_DRIVING_HGV | "driving-hgv"|
|PROFIL_CYCLING_HGV | "cycling-hgv"|
|PROFIL_CYCLING_REGULAR | "cycling-regular"|
|PROFIL_CYCLING_ROAD | "cycling-road"|
|PROFIL_CYCLING_MOUNTAIN | "cycling-mountain"|
|PROFIL_CYCLING_ELETRIC | "cycling-electric"|
|PROFIL_FOOT_WALKING | "foot-walking"|
|PROFIL_FOOT_HIKING | "foot-hiking"|
|PROFIL_WHEELCHAIR | "wheelchair"|


list of available endpoints functions :
| Function name | endpoint link |
| --- | --- |
|getDirections() | https://openrouteservice.org/dev/#/api-docs/v2/directions/{profile}/get|
|getDirectionsWithSettings() | https://openrouteservice.org/dev/#/api-docs/v2/directions/{profile}/post|
|getDirectionsWithGeoJson() | https://openrouteservice.org/dev/#/api-docs/v2/directions/{profile}/geojson/post|
|getDirectionsWithGpx() | https://openrouteservice.org/dev/#/api-docs/v2/directions/{profile}/gpx/post|
|searchGeocode() | https://openrouteservice.org/dev/#/api-docs/geocode/search/get|
|autocompleteGeocode() | https://openrouteservice.org/dev/#/api-docs/geocode/autocomplete/get|
|reverseGeocode() | https://openrouteservice.org/dev/#/api-docs/geocode/reverse/get|



## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.