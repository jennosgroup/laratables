<?php

namespace Laratables;

use Illuminate\View\View;
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
     * The view options.
     */
    protected array $viewOptions = [];

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
     * Return the view.
     *
     * @param  string  $path
     * @param  array  $options
     *
     * @return Illuminate\View\View
     */
    public static function view(string $path, array $options = []): View
    {
        $table = static::make();

        $options['table'] = $table;

        $table->viewOptions = $options;

        return view($path, $options);
    }

    /**
     * Make the table.
     *
     * @return $this
     */
    public static function make(): self
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
     * Render the table view.
     *
     * @param  array  $options
     *
     * @return Illuminate\View\View
     */
    public function render(array $options = []): View
    {
        $table = $this->viewOptions['table'];

        $options = array_merge($this->viewOptions, $options);

        $options['table'] = $table;

        return view('laratables::table', $options);
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
