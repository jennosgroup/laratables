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
        $parts = $this->getUrlParts();
        $queryString = $parts[5] ?? null;
        return ! empty($queryString);
    }

    /**
     * Get the currently submitted url query string parameters.
     *
     * @param  array|string|null  $except
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
     * @param  array|string|null  $except
     *
     * @return array
     */
    public function buildQueryParameters($except = null): array
    {
        $output = [];

        if (! is_array($except)) {
            $except = func_get_args();
        }

        $queryParameters = explode('&', $this->getQueryString());

        foreach ($queryParameters as $parameter) {

            if (empty($parameter)) {
                continue;
            }

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
     * @return string|null
     */
    public function getQueryString(): string
    {
        $parts = $this->getUrlParts();
        return $parts[5];
    }

    /**
     * Get the whitelisted query parameters.
     *
     * @return array
     */
    public function getWhitelistedQueryParameters(): array
    {
        return [
            $this->getPageKey(),
            $this->getPerPageKey(),
            $this->getSearchKey(),
            $this->getOrderKey(),
            $this->getSortKey(),
            $this->getSectionKey(),
        ];
    }

    /**
     * Get the url parts.
     *
     * @return array
     */
    public function getUrlParts(): array
    {
        if ($parts = $this->cache->get('url.parts')) {
            return $parts;
        }

        preg_match('/([a-zA-Z]+):\/\/([^\/|\?|:]+):*([0-9]*)\/*([^\?|#]*)\?*([^\#]*)\#*(.*)/', urldecode(url()->full()), $matches);

        $this->cache->put('url.parts', $matches, 0);

        return $matches;
    }
}
