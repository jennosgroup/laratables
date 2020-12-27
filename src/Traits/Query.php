<?php

namespace Laratables\Traits;

use Exception;
use Laratables\Exceptions\QueryException;

trait Query
{
    /**
     * The current query.
     *
     * @var Illuminate\Database\Query\Builder
     */
    protected $query;

    /**
     * Get whether we have a query builder to work with.
     *
     * @return bool
     */
    protected function hasBaseQuery(): bool
    {
        return method_exists($this, 'baseQuery');
    }

    /**
     * Get the current query to continue to build upon.
     *
     * @return Illuminate\Database\Query\Builder
     */
    protected function getQuery()
    {
        if (is_null($this->query)) {
            $this->query = $this->getFreshQuery();
        }

        return $this->query;
    }

    /**
     * Get a fresh instance of the base query.
     *
     * @return Illuminate\Database\Query\Builder
     *
     * @throws Laratables\Exceptions\QueryException
     */
    protected function getFreshQuery()
    {
        if (! $this->hasBaseQuery()) {
            throw QueryException::baseQueryMissing(get_class($this));
        }

        return $this->baseQuery();
    }

    /**
     * Refresh the query.
     *
     * @return $this
     */
    protected function refreshQuery(): self
    {
        $this->query = $this->getFreshQuery();
        return $this;
    }
}
