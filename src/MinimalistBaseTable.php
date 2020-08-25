<?php

namespace Laratables;

abstract class MinimalistBaseTable extends BaseTable
{
    /**
     * Attributes that should always be present.
     */
    protected array $masterAttributes = [
        'sort_button' => ['class' => 'laratables-sort-column-button'],
        'search_submit' => ['class' => 'laratables-search-submit'],
    ];
}
