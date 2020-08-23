<?php

namespace Laratables\Traits;

use Exception;
use Laratables\Exceptions\QueryException;

trait Query
{
    /**
     * The current query.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * Get whether we have a query builder to work with.
     *
     * @return bool
     */
    public function hasBaseQuery(): bool
    {
        return method_exists($this, 'baseQuery');
    }

    /**
     * Get the current query to continue to build upon.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function getQuery()
    {
        if (! $this->hasBaseQuery()) {
            throw QueryException::baseQueryMissing();
        }

        if (is_null($this->query)) {
            $this->query = $this->getFreshQuery();
        }

        return $this->query;
    }

    /**
     * Refresh the query.
     *
     * @return $this
     */
    public function refreshQuery(): self
    {
        $this->query = $this->getFreshQuery();
        return $this;
    }

    /**
     * Get a fresh instance of the base query.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function getFreshQuery()
    {
        return $this->baseQuery();
    }
}
