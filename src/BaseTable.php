<?php

namespace Laratables;

use Illuminate\Support\Str;
use Illuminate\Cache\ArrayStore;

abstract class BaseTable
{
    use Traits\Data;
    use Traits\Sort;
    use Traits\Query;
    use Traits\Search;
    use Traits\Columns;
    use Traits\Checkbox;
    use Traits\Paginate;
    use Traits\UrlQuery;
    use Traits\Sections;
    use Traits\Attributes;
    use Traits\BulkOptions;
    use Traits\WrapperContent;
    use Traits\AttributesString;
    use Traits\TableContentOutput;

    /**
     * The cache store.
     */
    protected ArrayStore $cache;

    /**
     * Whether to use ajax.
     */
    protected bool $shouldUseAjax = false;

    /**
     * The unique id for the table.
     */
    protected string $id;

    /**
     * The id field for the items being iterated over.
     */
    protected string $idField = 'id';

    /**
     * Indicate whether the table footer should be displayed.
     */
    protected bool $displayFooter = true;

    /**
     * The no items message.
     */
    protected string $noItemsMessage = 'There is nothing to display.';

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
     * Render the table view.
     *
     * @return Illuminate\Http\Response
     */
    public static function make()
    {
        $table = new static;

        $table->id = $table->makeUniqueId();

        if ($table->hasSearchRequest()) {
            $table->handleSearchRequest();
        }

        if ($table->hasSortRequest()) {
            $table->handleSortRequest();
        }

        if (method_exists($table, 'manipulateQuery')) {
            $table->{'manipulateQuery'}();
        }

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
     * Get the items id field.
     *
     * @return string
     */
    public function getIdField(): string
    {
        return $this->idField;
    }

    /**
     * Get the indicator if we should display the table footer.
     *
     * @return bool
     */
    public function shouldDisplayFooter(): bool
    {
        return $this->displayFooter;
    }

    /**
     * Get the no items message.
     *
     * @return string
     */
    public function getNoItemsMessage(): string
    {
        return $this->noItemsMessage;
    }

    /**
     * Check whether we should use ajax.
     *
     * @return bool
     */
    public function shouldUseAjax(): bool
    {
        return $this->shouldUseAjax;
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

    /**
     * The standard default output of blade.
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
     * The standard escape output of blade.
     *
     * @param  mixed  $value
     *
     * @return mixed
     */
    protected function escape($value)
    {
        return e($value);
    }
}
