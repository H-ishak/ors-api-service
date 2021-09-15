<?php
namespace HIshak\OrsLaravelApi\Exceptions;
use Exception;

//The request is larger than the server is able to process, the data provided in the request exceeds the capacity limit.
class RequestExceededException extends Exception
{
    //
}