<?php

namespace Laratables\Exceptions;

use Exception;

class AttributeException extends Exception
{
    /**
     * Table missing exception.
     *
     * @param  string  $class
     *
     * @return void
     *
     * @throws Laratables\Exceptions\AttributeException
     */
    public static function tableMissing(string $class)
    {
        $message = "A table must be set through the `".$class."::table()` method";
        return new self($message);
    }

    /**
     * Element missing exception.
     *
     * @param  string  $class
     *
     * @return void
     *
     * @throws Laratables\Exceptions\AttributeException
     */
    public static function elementMissing(string $class)
    {
        $message = "An element must be set through the `".$class."::element()` method";
        return new self($message);
    }
}
