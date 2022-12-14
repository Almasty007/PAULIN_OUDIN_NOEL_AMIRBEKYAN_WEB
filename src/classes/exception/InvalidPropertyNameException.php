<?php
namespace iutnc\sae\exception;
use Exception;
use Throwable;

class InvalidPropertyNameException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}