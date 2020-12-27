<?php

namespace Laratables\Traits;

trait Sanitize
{
    /**
     * The default output of blade.
     *
     * @param  mixed  $value
     *
     * @return mixed
     */
    protected function output($value)
    {
        return e($value);
    }

    /**
     * The escape output of blade.
     *
     * @param  mixed  $value
     *
     * @return mixed
     */
    protected function escape($value)
    {
        return htmlspecialchars($value);
    }
}
