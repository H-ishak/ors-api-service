<?php
namespace HIshak\OrsLaravelApi\Exceptions;
use Exception;

//The server is currently unavailable due to overload or maintenance.
class ServerUnavailableException extends Exception
{
    //
}
//Indicates that the server does not support the functionality needed to fulfill the request.
class FunctionalityUnsupportedException extends Exception
{
    //
}
//An unexpected error was encountered and a more detailed error code is provided.
class UnexpectedException extends Exception
{
    //
}
//The request is larger than the server is able to process, the data provided in the request exceeds the capacity limit.
class RequestExceededException extends Exception
{
    //
}
//The specified HTTP method is not supported. For more details, refer to the EndPoint documentation.
class UnSupportedMethodException extends Exception
{
    //
}
//An element could not be found. If possible, a more detailed error code is provided.
class NotFoundException extends Exception
{
    //
}
//Forbidden
class ForbiddenException extends Exception
{
    //
}
//Unauthorized
class UnauthorizedException extends Exception
{
    //
}
//The request is incorrect and therefore can not be processed.
class IncorrectException extends Exception
{
    //
}