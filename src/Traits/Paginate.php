<?php

namespace Laratables\Traits;

use Laratables\Exceptions\QueryException;

trait Paginate
{
    /**
     * The page key.
     */
    protected string $pageKey = 'page';

    /**
     * The per page key.
     */
    protected string $perPageKey = 'per_page';

    /**
     * The per page total.
     */
    protected int $perPageTotal = 15;

    /**
     * Indicate whether we should paginate the query.
     */
    protected bool $shouldPaginate = true;

    /**
     * Indicate whether we should display the pagination links.
     */
    protected bool $shouldDisplayPagination = true;

    /**
     * Whether we should display the per page options.
     */
    protected bool $shouldDisplayPerPageOptions = false;

    /**
     * Get the per page total.
     *
     * @return int
     */
    public function getPerPageTotal(): int
    {
        if ($this->hasPerPageRequest()) {
            return $this->getRequestedPerPageTotal();
        }
        return $this->perPageTotal;
    }

    /**
     * Check if we have a per page request.
     *
     * @return bool
     */
    public function hasPerPageRequest(): bool
    {
        return isset($_GET[$this->getPerPageKey()]);
    }

    /**
     * Get the requested pagination total.
     *
     * @return int
     */
    public function getRequestedPerPageTotal(): int
    {
        return $_GET[$this->getPerPageKey()];
    }

    /**
     * Check if we have a per page total.
     *
     * @return bool
     */
    public function hasPerPageTotal(): bool
    {
        return ! empty($this->getPerPageTotal());
    }

    /**
     * Get the pagination total key.
     *
     * @return string
     */
    public function getPerPageKey(): string
    {
        return $this->perPageKey;
    }

    /**
     * Get the page key.
     *
     * @return string
     */
    public function getPageKey(): string
    {
        return $this->pageKey;
    }

    /**
     * Get the page number.
     *
     * @return int
     */
    public function getPageNumber(): int
    {
        $page = $_GET[$this->getPageKey()] ?? 1;

        if (! is_numeric($page) || $page == 0) {
            return 1;
        }

        return $page;
    }

    /**
     * Get the indicator if we should paginate.
     *
     * @return bool
     */
    public function shouldPaginate(): bool
    {
        return $this->shouldPaginate;
    }

    /**
     * Get the indicator of whether we should display the pagination links.
     *
     * @return bool
     */
    public function shouldDisplayPagination(): bool
    {
        return $this->shouldPaginate() && $this->shouldDisplayPagination;
    }

    /**
     * Display the pagination links.
     *
     * @return string
     */
    public function displayPagination(): string
    {
        if (! $this->hasBaseQuery()) {
            throw QueryException::baseQueryMissing(get_class($this));
        }

        return $this->getData()
            ->withQueryString()
            ->setPageName($this->getPageKey())
            ->links();
    }

    /**
     * Whether we should display per page options.
     *
     * @return bool
     */
    public function shouldDisplayPerPageOptions(): bool
    {
        return $this->shouldDisplayPerPageOptions;
    }

    /**
     * Get the per page options.
     *
     * Expected results is an associated arrays of per page options.
     *
     * @return array
     */
    public function getPerPageOptions(): array
    {
        return [
            15 => 15,
            25 => 25,
            50 => 50,
            100 => 100,
        ];
    }

    /**
     * Get the per page select attributes string.
     *
     * @return string
     */
    public function getPerPageSelectAttributesString(): string
    {
        $attributes = $this->getElementAttributes('per_page_select');
        $attributes = $this->getAndMergeElementAttributes('bulk_per_page_select', $attributes);
        $attributes['name'] = $this->getPerPageKey();
        $attributes['laratables-id'] = 'per-page-select';

        return $this->parseAttributesForOutput($attributes);
    }
}
