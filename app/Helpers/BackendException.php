<?php

namespace App\Helpers;

/**
 * Class BackendException
 * @package App\Helpers\Exceptions
 */
class BackendException extends \Exception
{
    /**
     * BackendException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }
}
