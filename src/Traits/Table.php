<?php

namespace Laratables\Traits;

use Illuminate\Support\Str;

Trait Table
{
    /**
     * The no items message.
     */
    protected string $noItemsMessage = 'There is nothing to display.';

    /**
     * Indicate whether the table footer should be displayed.
     */
    protected bool $displayTfoot = true;

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
     * Check if we should display the table footer.
     *
     * @return bool
     */
    public function shouldDisplayTfoot(): bool
    {
        return $this->displayTfoot;
    }

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

        return $this->output($columnTitle);
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
    public function getTbodyTdContent($item, string $columnId, int $columnNumber, int $rowNumber)
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
            ? $this->output($item->{$columnId})
            : ($item[$columnId] ? $this->output($item[$columnId]) : null);
    }

    /**
     * Get the thead th attributes.
     *
     * @param  string  $columnId
     * @param  int  $columnNumber
     * @param  string  $position
     *
     * @return string|null
     */
    public function getThElementHtml(string $columnId, int $columnNumber, string $position): ?string
    {
        $attributes = $this->getElementAttributes('t'.$position.'_th');

        if (method_exists($this, $method = 'get'.Str::studly($columnId).'ThAttributes')) {
            $attributes = $this->$method($attributes, $columnNumber, $position);
        } else if (method_exists($this, $method = 'getThAttributes')) {
            $attributes = $this->$method($attributes, $columnId, $columnNumber, $position);
        }

        return $this->parseAttributesForOutput($attributes);
    }

    /**
     * Get the tbody tr attributes.
     *
     * @param  object  $item
     * @param  int  $rowNumber
     *
     * @return string|null
     */
    public function getTbodyTrElementHtml($item, $rowNumber): ?string
    {
        $attributes = $this->getElementAttributes('tbody_tr');

        if (method_exists($this, $method = 'getTbodyTrAttributes')) {
            $attributes = $this->$method($attributes, $item, $rowNumber);
        }

        return $this->parseAttributesForOutput($attributes);
    }

    /**
     * Get the tbody td attributes.
     *
     * @param  object  $item
     * @param  string  $columnId
     * @param  int  $columnNumber
     * @param  int  $rowNumber
     *
     * @return string|null
     */
    public function getTbodyTdElementHtml($item, $columnId, $columnNumber, $rowNumber): ?string
    {
        $attributes = $this->getElementAttributes('tbody_td');

        if (method_exists($this, $method = 'get'.Str::studly($columnId).'TdAttributes')) {
            $attributes = $this->$method($attributes, $item, $columnNumber, $rowNumber);
        } else if (method_exists($this, $method = 'getTdAttributes')) {
            $attributes = $this->$method($attributes, $item, $columnId, $columnNumber, $rowNumber);
        }

        return $this->parseAttributesForOutput($attributes);
    }
}
