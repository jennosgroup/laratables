<?php

namespace Laratables\Traits;

use Illuminate\Support\Str;

trait AttributesString
{
    /**
     * Get the additional wrapper attributes.
     *
     * @return string
     */
    public function getWrapperAdditionalAttributesString(): string
    {
        return $this->parseAttributesForOutput([
            'laratables-wrapper' => 'yes',
            'laratables-id' => $this->getId(),
            'laratables-checkbox-name' => $this->getCheckboxName(),
        ]);
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
    public function getThAttributesString(string $columnId, int $columnNumber, string $position): ?string
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
    public function getTbodyTrAttributesString($item, $rowNumber): ?string
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
    public function getTbodyTdAttributesString($item, $columnId, $columnNumber, $rowNumber): ?string
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
