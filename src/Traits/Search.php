<?php

namespace Laratables\Traits;

trait Search
{
    /**
     * The columns that are searchable.
     *
     * A column does not have to be visible to be searchable.
     *
     * @var array
     */
    protected array $searchColumns = [];

    /**
     * The search key.
     *
     * @var string
     */
    protected string $searchKey = 'search';

    /**
     * Should display the search field.
     *
     * @var bool
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
     * @return string
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
        if (empty($this->getSearchColumns())) {
            return $this;
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
        if (! $this->hasBaseQuery()) {
            return;
        }

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
