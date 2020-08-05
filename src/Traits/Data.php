<?php

namespace Laratables\Traits;

use Illuminate\Support\Collection;
use Laratables\Exceptions\DataException;
use Laratables\Exceptions\QueryException;

trait Data
{
    /**
     * The data to work with.
     *
     * This must be something that can be iterated over.
     *
     * @var mixed
     */
    protected $data = [];

    /**
     * Check if the data is iterable.
     *
     * @return bool
     */
    public function dataIsIterable(): bool
    {
        return is_iterable($this->data) || is_object($this->data);
    }

    /**
     * Get the data to work with.
     *
     * It is not advised to perform logics inside this method as an override
     * to generate your data i.e a database query. This method is called in
     * various places thus those calls will be needlessly repeated. If you want
     * to customize the way that data is generated, override the `generateData` method.
     *
     * This must return data that can be iterated over.
     *
     * @return mixed
     */
    public function getData()
    {
        if (! $this->dataIsIterable()) {
            return DataException::notIterable();
        }
        return $this->data;
    }

    /**
     * Check if we have data to work with.
     *
     * @return bool
     */
    public function hasData(): bool
    {
        if ($this->getData() instanceof Collection) {
            return $this->getData()->isNotEmpty();
        }
        return ! empty($this->getData());
    }

    /**
     * Generate the data to work with.
     *
     * By default, this relies on there being a base query to work with. By
     * base query, we mean an instance of the laravel query builder (Eloquent or DB).
     *
     * If you wish for your data to be generated without the query builder, this is
     * the method to override.
     *
     * @param  Laratables\BaseTable  $instance
     *
     * @return mixed  Must be data that can be iterable over
     */
    protected function generateData($instance)
    {
        if (! $instance->hasBaseQuery()) {
            throw QueryException::baseQueryMissing();
        }

        if (! $instance->shouldPaginate()) {
            return $instance->getQuery()->get();
        }

        if ($instance->hasPaginationTotal()) {
            return $instance->getQuery()->paginate($instance->getPaginationTotal());
        }

        return $instance->getQuery()->paginate();
    }
}
