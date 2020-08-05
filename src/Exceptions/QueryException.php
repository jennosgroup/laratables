<?php

namespace Laratables\Exceptions;

use Exception;

class QueryException extends Exception
{
    /**
     * Base query missing exception.
     *
     * @return void
     *
     * @throws Laratables\Exceptions\QueryException
     */
    public static function baseQueryMissing()
    {
        $message = "Your table class does not have a 'baseQuery' method defined.";
        $message .= " Set a 'baseQuery' method that returns an instance of the query builder (Eloquent or DB) to continue working with a query.";

        return new self($message);
    }
}
