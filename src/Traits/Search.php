<?php

namespace Laratables\Traits;

use Laratables\Exceptions\QueryException;

trait Search
{
    /**
     * The columns that are searchable.
     *
     * A column does not have to be visible to be searchable.
     */
    protected array $searchColumns = [];

    /**
     * The search key.
     */
    protected string $searchKey = 'search';

    /**
     * Should display the search field.
     */
    protected bool $displaySearch = false;

    /**
     * Get the columns that are searchable.
     *
     * @return array
     */
    public function getSearchColumns(): array
    {
        return $this->searchColumns;
    }

    /**
     * Check if a column is sortable.
     *
     * @param  string  $column
     *
     * @return bool
     */
    public function isColumnSearchable(string $column): bool
    {
        return in_array($column, $this->getSearchColumns());
    }

    /**
     * Get the search key.
     *
     * @return string
     */
    public function getSearchKey(): string
    {
        return $this->searchKey;
    }

    /**
     * Get the search value.
     *
     * @return string|null
     */
    public function getSearchValue(): ?string
    {
        return $_GET[$this->getSearchKey()] ?? null;
    }

    /**
     * Whether we should display the search field.
     *
     * @return bool
     */
    public function shouldDisplaySearch(): bool
    {
        return $this->displaySearch;
    }

    /**
     * Get the search icon markup.
     *
     * @return string
     */
    public function getSearchIconMarkup(): string
    {
        return '<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-search-icon"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>';
    }

    /**
     * Get the search input attributes string.
     *
     * @return string
     */
    public function getSearchInputAttributesString(): string
    {
        $attributes = $this->getElementAttributes('search_input');
        $attributes['laratables-id'] = 'search-input';
        $attributes['type'] = 'search';
        $attributes['name'] = $this->getSearchKey();
        $attributes['value'] = $this->getSearchValue();

        return $this->parseAttributesForOutput($attributes);
    }

    /**
     * Get the search button attributes string.
     *
     * @return string
     */
    public function getSearchButtonAttributesString(): string
    {
        $attributes = $this->getElementAttributes('search_submit');
        $attributes['laratables-id'] = 'search-submit';
        $attributes['type'] = 'submit';

        return $this->parseAttributesForOutput($attributes);
    }

    /**
     * Check if we have a search request.
     *
     * @return bool
     */
    public function hasSearchRequest(): bool
    {
        return isset($_GET[$this->getSearchKey()]);
    }

    /**
     * Handle the search request.
     *
     * @return $this
     */
    public function handleSearchRequest(): self
    {
        if (! $this->hasBaseQuery()) {
            QueryException::baseQueryMissing(get_class($this));
        }

        $this->handleSearchQuery($this->getSearchValue());

        return $this;
    }

    /**
     * Handle the search query.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function handleSearchQuery($value)
    {
        $this->getQuery()->where(function ($query) use ($value) {
            foreach ($this->getSearchColumns() as $index => $column) {
                if ($index == 0) {
                    $query = $query->where(htmlspecialchars($column), 'like', '%'.$value.'%');
                } else {
                    $query = $query->orWhere(htmlspecialchars($column), 'like', '%'.$value.'%');
                }
            }
        });
    }
}
