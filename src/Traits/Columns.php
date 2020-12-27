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
        return $this->getColumnsList();
    }

    /**
     * Get the columns list.
     *
     * @return array
     */
    public function getColumnsList(): array
    {
        $columns = $this->columns;

        if ($this->hasCheckbox()) {
            $columns = array_merge(['checkbox' => ''], $columns);
        }

        if ($this->hasActions()) {
            $columns = array_merge($columns, ['actions' => $this->getActionColumnTitle()]);
        }

        return $columns;
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
