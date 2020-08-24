<?php

namespace Laratables\Traits;

trait Columns
{
    /**
     * The visible table columns.
     *
     * These should be key => value pairs, with the key being an identifier for
     * the column, while the value being the column title.
     */
    protected array $columns = [];

    /**
     * Get the table columns.
     *
     * @return array
     */
    public function getColumns(): array
    {
        if (! $this->hasCheckbox()) {
            return $this->columns;
        }
        return array_merge(['checkbox' => ''], $this->columns);
    }

    /**
     * Get the total number of visible columns.
     *
     * @return int
     */
    public function getColumnsCount(): int
    {
        return count($this->getColumns());
    }
}
