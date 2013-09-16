<?php
class AppException extends Exception
{
}

class ValidationException extends AppException
{
}

class InvalidHTTPRequestException extends AppException
{
}

class RecordNotExistException extends AppException
{
}