<?php

namespace Laratables\Traits;

use Laratables\Exceptions\QueryException;

trait Paginate
{
    /**
     * The pagination total.
     *
     * Leaving this value as null will allow the laravel default to be used.
     *
     * @var int|null
     */
    protected ?int $paginationTotal = null;

    /**
     * The pagination total key.
     *
     * @var string
     */
    protected string $paginationTotalKey = 'per_page';

    /**
     * The page key.
     *
     * @var string
     */
    protected string $pageKey = 'page';

    /**
     * Indicate whether we should paginate the query.
     *
     * @var bool
     */
    protected bool $shouldPaginate = true;

    /**
     * Indicate whether we should display the pagination links.
     *
     * @var bool
     */
    protected bool $shouldDisplayPagination = true;

    /**
     * Whether we should display the per page options.
     *
     * @var bool
     */
    protected bool $displayPerPageOptions = false;

    /**
     * Get the pagination total.
     *
     * @return int|null
     */
    public function getPaginationTotal(): ?int
    {
        if ($this->hasPaginationRequest()) {
            return $this->getRequestedPaginationTotal();
        }
        return $this->paginationTotal;
    }

    /**
     * Check if we have a pagination per page request.
     *
     * @return bool
     */
    public function hasPaginationRequest(): bool
    {
        return isset($_GET[$this->getPaginationTotalKey()]);
    }

    /**
     * Get the requested pagination total.
     *
     * @return int
     */
    public function getRequestedPaginationTotal(): int
    {
        return $_GET[$this->getPaginationTotalKey()];
    }

    /**
     * Check if we have a pagination total.
     *
     * @return bool
     */
    public function hasPaginationTotal(): bool
    {
        return ! empty($this->getPaginationTotal());
    }

    /**
     * Get the pagination total key.
     *
     * @return string
     */
    public function getPaginationTotalKey(): string
    {
        return $this->paginationTotalKey;
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
            throw QueryException::baseQueryMissing();
        }
        return $this->getData()->links();
    }

    /**
     * Whether we should display per page options.
     *
     * @return bool
     */
    public function shouldDisplayPerPageOptions(): bool
    {
        return $this->displayPerPageOptions;
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
}
