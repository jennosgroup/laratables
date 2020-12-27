<?php

namespace Laratables;

use Illuminate\Support\Str;
use Illuminate\Cache\ArrayStore;

abstract class BaseTable
{
    use Traits\Data,
    Traits\Sort,
    Traits\Table,
    Traits\Query,
    Traits\Search,
    Traits\Wrapper,
    Traits\Columns,
    Traits\Actions,
    Traits\Checkbox,
    Traits\Paginate,
    Traits\UrlQuery,
    Traits\Sections,
    Traits\Sanitize,
    Traits\Attributes,
    Traits\BulkOptions;

    /**
     * The cache store.
     */
    protected ArrayStore $cache;

    /**
     * The unique id for the table.
     */
    protected string $id;

    /**
     * Create an instance of the class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cache = new ArrayStore;
    }

    /**
     * Make an instance of the table.
     *
     * @return $this
     */
    public static function make(): self
    {
        $table = new static;

        // Assign a unique id to the table
        $table->id = $table->makeUniqueId();

        // Perform search queries
        if ($table->hasSearchRequest()) {
            $table->handleSearchRequest();
        }

        // Perform sort queries
        if ($table->hasSortRequest()) {
            $table->handleSortRequest();
        }

        // Allows us to further manipulate the query and searching and sorting is done
        if (method_exists($table, $method = 'manipulateQuery')) {
            $table->$method();
        }

        // We set the generated data so it can be retrieved later on in it's final stages
        $table->data = $table->generateData($table);

        return $table;
    }

    /**
     * Get the table id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Generate a unique id.
     *
     * @return string
     */
    protected function makeUniqueId(): string
    {
        return Str::random(20);
    }
}
