<?php

namespace Laratables\Exceptions;

use Exception;

class DataException extends Exception
{
    /**
     * Data is not iterable exception.
     *
     * @return void
     *
     * @throws Laratables\Exceptions\DataException
     */
    public static function notIterable()
    {
        return new self('The data generated for the table to work with is not iterable.');
    }
}
