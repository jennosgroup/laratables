<?php

namespace Laratables\Traits;

use Illuminate\Support\Str;

trait TableContentOutput
{
    /**
     * Get the column th title.
     *
     * @param  string  $columnId
     * @param  string  $columnTitle
     * @param  int  $columnNumber
     * @param  string  $position
     *
     * @return string
     */
    public function getThTitle(string $columnId, string $columnTitle = null, int $columnNumber, string $position)
    {
        // Allows filtering the title of a specific column
        if (method_exists($this, $method = 'get'.Str::studly($columnId).'ColumnTitle')) {
            return $this->$method($columnTitle, $columnNumber, $position);
        }

        // Allow general filtering for all columns
        if (method_exists($this, $method = 'getColumnTitle')) {
            return $this->$method($columnId, $columnTitle, $columnNumber, $position);
        }

        return $this->escape($columnTitle);
    }

    /**
     * Get the row content.
     *
     * @param  mixed  $item
     * @param  string  $columnId
     * @param  int  $columnNumber
     * @param  int  $rowNumber
     *
     * @return string
     */
    public function getTdContent($item, string $columnId, int $columnNumber, int $rowNumber)
    {
        // Allows filtering of a specific column content
        if (method_exists($this, $method = 'get'.Str::studly($columnId).'ColumnContent')) {
            return $this->$method($item, $columnNumber, $rowNumber);
        }

        // Allows filtering of any column
        if (method_exists($this, $method = 'getColumnContent')) {
            return $this->$method($item, $columnId, $columnNumber, $rowNumber);
        }

        return $item->{$columnId}
            ? $this->escape($item->{$columnId})
            : ($item[$columnId] ? $this->escape($item[$columnId]) : null);
    }
}
