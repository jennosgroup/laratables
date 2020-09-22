<?php

namespace Laratables\Traits;

use Illuminate\Support\Collection;
use Laratables\Exceptions\DataException;
use Laratables\Exceptions\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $data = $this->getData();

        if ($data instanceof Collection) {
            return $data->isNotEmpty();
        }

        if ($data instanceof LengthAwarePaginator) {
            return $data->total() >= 1;
        }

        return ! empty($data);
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
            throw QueryException::baseQueryMissing(get_class($this));
        }

        if (! $instance->shouldPaginate()) {
            return $instance->getQuery()->get();
        }

        if ($instance->hasPerPageTotal()) {
            return $instance->getQuery()->paginate($instance->getPerPageTotal());
        }

        return $instance->getQuery()->paginate();
    }

    /**
     * Check if the data is iterable.
     *
     * @return bool
     */
    protected function dataIsIterable(): bool
    {
        return is_iterable($this->data) || is_object($this->data);
    }
}
