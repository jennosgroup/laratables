<?php

namespace Laratables\Traits;

trait UrlQuery
{
    /**
     * Check if the current request has query parameters.
     *
     * @return bool
     */
    public function hasQueryParameters(): bool
    {
        return url()->current() !== url()->full();
    }

    /**
     * Get the currently submitted url query string parameters.
     *
     * @param  array|string  $except
     *
     * @return array
     */
    public function getQueryParameters($except = null): array
    {
        if (! is_array($except) && ! is_null($except)) {
            $except = func_get_args();
        }

        return $this->buildQueryParameters($except);
    }

    /**
     * Build the array for the query parameters.
     *
     * @param  array  $except
     *
     * @return array
     */
    public function buildQueryParameters(array $except = []): array
    {
        $output = [];

        $queryParameters = explode('&', $this->getQueryString());

        foreach ($queryParameters as $parameter) {

            $parts = explode('=', $parameter);
            $key = $parts[0];
            $value = $parts[1];

            if (! in_array($key, $except)) {
                $output[$key] = $value;
            }
        }

        return $output;
    }

    /**
     * Get the query string for the current $_GET request.
     *
     * @return string
     */
    public function getQueryString(): string
    {
        $queryString = str_replace(url()->current(), '', url()->full());
        return preg_replace('/^\?{1}/', '', urldecode($queryString));
    }
}
