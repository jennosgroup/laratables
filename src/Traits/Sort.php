<?php

namespace Laratables\Traits;

use Laratables\Exceptions\QueryException;

trait Sort
{
    /**
     * The columns that are sortable.
     *
     * Only visible columns can be sortable.
     */
    protected array $sortColumns = [];

    /**
     * The sort by key.
     */
    protected string $sortKey = 'sort_by';

    /**
     * The order key.
     */
    protected string $orderKey = 'order';

    /**
     * Whether to allow multiple sorting.
     */
    protected bool $allowMultipleSorting = true;

    /**
     * Get the columns that are sortable.
     *
     * @return array
     */
    public function getSortColumns(): array
    {
        return $this->sortColumns;
    }

    /**
     * Check if a column is sortable.
     *
     * @param  string  $column
     *
     * @return bool
     */
    public function isColumnSortable(string $column): bool
    {
        return in_array($column, $this->getSortColumns());
    }

    /**
     * Get the sortable key.
     *
     * @return string
     */
    public function getSortKey(): string
    {
        return $this->sortKey;
    }

    /**
     * Get the order key.
     *
     * @return string
     */
    public function getOrderKey(): string
    {
        return $this->orderKey;
    }

    /**
     * Check if we should allow multiple sorting.
     *
     * @return bool
     */
    public function allowMultipleSorting(): bool
    {
        return $this->allowMultipleSorting;
    }

    /**
     * Get the sort value.
     *
     * @return string|null
     */
    public function getSortValue(): ?string
    {
        return $_GET[$this->getSortKey()] ?? null;
    }

    /**
     * Get the order value.
     *
     * @return string|null
     */
    public function getOrderValue(): ?string
    {
        return $_GET[$this->getOrderKey()] ?? null;
    }

    /**
     * Get the column order value, 'asc' or 'desc'.
     *
     * @param  string  $column
     *
     * @return string|null
     */
    public function getColumnOrderValue($column): ?string
    {
        $sorts = $this->getSortValue();
        $orders = $this->getOrderValue();

        $sorts = empty($sorts) ? [] : explode(',', $sorts);
        $orders = empty($orders) ? [] : explode(',', $orders);

        if (! in_array($column, $sorts)) {
            return null;
        }

        $position = array_search($column, $sorts);

        return $orders[$position] ?? null;
    }

    /**
     * Build the form column sort and order input fields.
     *
     * @param  string  $column
     *
     * @return string
     */
    public function generateColumnSortAndOrderInput($column)
    {
        $sorts = $this->getSortValue();
        $orders = $this->getOrderValue();

        if (! $this->allowMultipleSorting()) {

            if ($orders == 'asc') {
                $orders = 'desc';
            } else {
                $orders = 'asc';
            }

            $input = "<input type='hidden' name='".$this->getSortKey()."' value='".$column."'>";
            $input .= "<input type='hidden' name='".$this->getOrderKey()."' value='".$orders."'>";
            return $input;
        }

        if ($this->allowMultipleSorting()) {
            $sorts = empty($sorts) ? [] : explode(',', $sorts);
            $orders = empty($orders) ? [] : explode(',', $orders);
        } else {
            $sorts = empty($sorts) ? [] : [$sorts];
            $orders = empty($orders) ? [] : [$orders];
        }

        if (! in_array($column, $sorts)) {
            $sorts[] = $column;
        }

        if (empty($sorts)) {
            $sorts[] = $column;
        }

        $columnPosition = array_search($column, $sorts);

        if (isset($orders[$columnPosition])) {
            $orders[$columnPosition] = ($orders[$columnPosition] == 'asc') ? 'desc' : 'asc';
        } else {
            $orders[] = 'asc';
        }

        $input = "<input type='hidden' name='".$this->getSortKey()."' value='".implode(',', $sorts)."'>";
        $input .= "<input type='hidden' name='".$this->getOrderKey()."' value='".implode(',', $orders)."'>";

        return $input;
    }

    /**
     * Get the asc sort icon markup.
     *
     * @return string
     */
    public function getAscSortIconMarkup(): string
    {
        return '<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" class="arrow-down"><path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
    }

    /**
     * Get the desc sort icon markup.
     *
     * @return string
     */
    public function getDescSortIconMarkup(): string
    {
        return '<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" class="arrow-up"><path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
    }

    /**
     * Check if we have a sort request.
     *
     * @return bool
     */
    public function hasSortRequest(): bool
    {
        return isset($_GET[$this->getSortKey()]);
    }

    /**
     * Handle the sort request.
     *
     * @return $this
     */
    public function handleSortRequest(): self
    {
        $orders = [];
        $defaultSort = 'asc';

        $sortables = explode(',', $this->getSortValue());
        $orderables = explode(',', $this->getOrderValue());

        if (empty($sortables)) {
            return $this;
        }

        foreach ($sortables as $index => $column) {
            $orders[trim($column)] = $orderables[$index] ?? $defaultSort;
        }

        if (! $this->hasBaseQuery()) {
            QueryException::baseQueryMissing(get_class($this));
        }

        if (! empty($orders)) {
            $this->handleSortQuery($orders);
        }

        return $this;
    }

    /**
     * Handle the sort query.
     *
     * @param  array  $columns
     *
     * @return void
     */
    public function handleSortQuery(array $columns)
    {
        foreach ($columns as $column => $order) {
            $this->getQuery()->orderBy(htmlspecialchars($column), $order);
        }
    }
}
