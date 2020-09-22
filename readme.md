# Laratables

## Table Of Contents

1. [About](#about)
2. [Installation](#installation)
3. [Setup](#setup)
4. [Getting Started](#getting-started)
5. [Columns](#columns)
6. [Sortable Columns](#sortable-columns)
7. [Searchable Columns](#searchable-columns)

## About

Laratables is a laravel package that allows you to seemlessly generate html tables entirely using PHP classes.

## Installation

Install with composer `composer require jennosgroup/laratables`.

## Setup

Publish the package assets with artisan command `php artisan vendor:publish --tag=laratables-assets`.

Then include the `laratables.js` script file in your html markup `<script src="{{ asset('vendor/laratables/js/laratables.js') }}"></script>`.

## Getting Started

If you are going to create numerous html tables across your site that will share similar styles and features, it is best to create a basetable class and let all your other tables extend this class.

For example, let's create a class that extends `Laratables\BaseTable`.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{

}
```

To start things off, the table needs data to work with. Define a protected `baseQuery` method that holds your base query for us to build upon.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    //....

    /**
     * The base query to build upon.
     *
     * @return Illuminate\Database\Query\QueryBuilder
     */
    protected function query()
    {
        return Post::query();
    }
}
```

## Columns

It's very easy to define the table columns - all we need is an associative array. The array key is the column identifier
while the array value is the column title.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    // ....

    /**
     * The table columns.
     */
    protected array $columns = [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'date_of_birth' => 'Birth Date',
    ];
}
```

If your column array key matches your data item property, the content of that property will automatically be displayed as the table row content.

## Sortable Columns

To make columns sortable, list the id of the columns that you wish to be sortable.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    // .....

    /**
     * The sortable columns.
     */
    protected array $sortColumns = [
        'first_name', 'last_name',
    ];
}
```

You can customize the sort and order key that will be used in the GET request.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    // ....

    /**
     * The sort by key, which holds the column/identifier to sort by.
     */
    protected string $sortKey = 'sort_by';

    /**
     * The order key which holds the 'asc' or 'desc' value.
     */
    protected string $orderKey = 'order';
}
```

By default, multiple sorting is turned on. If you don't want multiple sorting, you can disable it.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    // ....

    /**
     * Whether to allow multiple sorting.
     */
    protected bool $allowMultipleSorting = false;
}
```

## Searchable Columns

To make columns searchable, define a protected $searchColumns property in your class, and add an array containing the column ids of the columns you wish to be searchable.

```php

class PostsListingTable extends Laratables\BaseTable
{
    // .....

    protected $searchColumns = [
        'first_name', 'last_name', 'status',
    ];
}
```

### Setting Data

### Base Query

### Pagination

### Display Footer

### Sort Query

### Search Query

### Attributes

### Checkbox

### Filter Output







getColumnTitle
get{ColumnId}ColumnTitle
get{ColumnId}HeadColumnTitle
get{ColumnId}Content



## Checkbox

To automatically generate a checkbox as the first table column, simply set the protected $hasCheckbox property to true.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    /**
     * Indicate whether checkboxes should be automatically generated.
     *
     * @var bool
     */
    protected $hasCheckbox = true;
}
```

If after inspecting the generated markup for the checkboxes, you feel that you require a different markup, worry not, as it's easy to customize. In your class, you can define some methods to override the default markup.

The `getHeadCheckboxMarkup`, `getBodyCheckboxMarkup` and `getFootCheckboxMarkup` methods can be used to define custom markup. Any content that needs escaping for output as blade does as standard, call on the `escape` method `$this->escape($...)` as the content from these methods are displayed as is.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //....

    /**
     * Get the markup for the thead checkbox.
     *
     * @param  int  $columnNumber
     *
     * @return string
     */
    public function getHeadCheckboxMarkup(int $columnNumber): string
    {
        $content = "<div id='checkbox-thead-container' class='checkbox-container checkbox-main-container'>";
        $content .= "<input type='checkbox' id='checkbox-main-top' class='checkbox-table checkbox-table-main'>";
        $content .= "</div>";

        return $content;
    }

    /**
     * Get the markup for the tbody checkbox.
     *
     * @param  object  $item
     * @param  int  $columnNumber
     *
     * @return string
     */
    public function getBodyCheckboxMarkup($item, int $columnNumber): string
    {
        $content = "<div id='checkbox-".$this->escape($item->{$this->getIdField()})."-container' class='checkbox-container checkbox-child-container'>";
        $content .= '<input type="checkbox" value="'.$this->escape($item->{$this->getIdField()}).'" id="checkbox-body-'.$this->escape($item->{$this->getIdField()}).'" class="checkbox-table checkbox-table-child">';
        $content .= "</div>";

        return $content;
    }

    /**
     * Get the markup for the tfoot checkbox.
     *
     * @param  int  $columnNumber
     *
     * @return string
     */
    public function getFootCheckboxMarkup(int $columnNumber): string
    {
        $content = "<div id='checkbox-tfoot-container' class='checkbox-container checkbox-main-container'>";
        $content .= "<input type='checkbox' id='checkbox-main-bottom' class='checkbox-table checkbox-table-main'>";
        $content .= "</div>";

        return $content;
    }
}
```

We have shown in the above example, the original code that generates the various checkbox markup. If you do change either of the markup, you will also need to let the class know the identifier for each of the head, body and foot checkboxes. The `getHeadCheckboxIdentifier`, `getBodyCheckboxIdentifier` and `getFootCheckboxIdentifier` are the methods responsible for fetching the identifer for the various checkboxes. These are important so that the package can be able to detect the checkboxes selected for bulk actions.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //....
    /**
     * Get the identifier to target when we want to detect that we should check
     * all the checkboxes, when the checkbox is checked in the head section
     *
     * @return string
     */
    public function getHeadCheckboxIdentifier(): string
    {
        return ".checkbox-table-main";
    }

    /**
     * Get the identifier to target when we want to detect which checkboxes in the
     * tbody are checked.
     *
     * @return string
     */
    public function getBodyCheckboxIdentifer(): string
    {
        return ".checkbox-table-child";
    }

    /**
     * Get the identifier to target when we want to detect that we should check
     * all the checkboxes, when the checkbox is checked in the foot section
     *
     * @return string
     */
    public function getFootCheckboxIdentifier(): string
    {
        return ".checkbox-table-main";
    }
}
```

Finally, if for some reason you require the checkbox to be in a position other than the first column, simply override the `getColumns` method.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //.....

    /**
     * Get the table visibile columns.
     *
     * @return array
     */
     public function getColumns(): array
     {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'date_of_birth' => 'Birth Date',
            'checkbox' => '',
        ];
     }
}
```

As you can see from the above example, no column title needs to be defined for the checkbox column. All that is required, is that the column key is set as 'checkbox' and the bulk of the work is already handled by the package.

## Sortable Columns

To indicate that columns are sortable, add the list of columns that should be sortable to the protected $sortColumns property.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //....

    /**
     * The columns that should be sortable.
     *
     * @var array
     */
    protected $sortColumns = [
        'first_name', 'last_name',
    ];
}
```

You will use the columns keys that you have defined for the visible columns. If you wish to customize the sort query, override the `handleSortQuery` method.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //.....

    /**
     * Handle the sort query.
     *
     * @param  array  $columns  The columns submitted as sortable.
     *
     * @return void
     */
    public function handleSortQuery(array $columns)
    {
        foreach ($columns as $column => $sort) {
            $this->getQuery()->orderBy(htmlspecialchars($column), $sort);
        }
    }
}
```

The above method is only called when columns are submitted for sorting, so there is no need to check if array is empty.

If you're relying on the query builder, always use the `getQuery` method on the class to chain the methods, so it continues to build on the base query defined.

If your data is not generated from a query, remember you can use the `getData` method to get the data to sort it. When you have sorted it, put back the data using the protected `setData` method, that accepts the new data as it's only argument.

By default, sort columns are sent as a string to the `order_by` $_GET parameter, while the `order` $_GET parameter is used to determine the sort order. If you would like to override these keys, override the `getSortKey` and `getOrderKey` methods.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //...

    /**
     * Get the sortable key.
     *
     * @return string
     */
    public function getSortKey(): string
    {
        return 'order_by';
    }

    /**
     * Get the order key.
     *
     * @return string
     */
    public function getOrderKey(): string
    {
        return 'order';
    }
}
```

## Searchable Columns

To indicate that columns are searchable, add the list of columns that should be sortable to the protected $searchColumns property.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //....

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    protected $searchColumns = [
        'first_name', 'last_name',
    ];
}
```

You will use the columns keys that you have defined for the visible columns. We have gone ahead and set a sensible handler for the search query. If you feel that it's insufficent for your needs, you can customize the search query, override the `handleSearchQuery` method, which accepts the search value as it's only parameter.

If your data is not generated from a query, remember you can use the `getData` method to get the data to search it. When you have searched it, put back the data using the protected `setData` method, that accepts the new data as it's only argument.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //.....

    /**
     * Handle the search query.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function handleSearchQuery($value)
    {
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
```

The above method is only called when a none null or none empty string is submitted for searching, so there is no need to check for those. Please note that we haven't checked for other empty values like false or zero. Remember if using the query builder, to use the `getQuery` method to continue to build upon the base query.

By default, the search query is sent as a string to the `search` $_GET parameter. If you would like to override this, override the `getSearchKey` method.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //...

    /**
     * Get the search key.
     *
     * @return string
     */
    public function getSearchKey(): string
    {
        return 'search';
    }
}
```

## Pagination

By default, the package assumes you want pagination out the box. To disable pagination, set the protected $shouldPaginate property to false. Or, you can add your own computed logic in the `shouldPaginate` method as shown in the below example. Whatever is in the `shouldPaginate` method will take precedence.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //...

    /**
     * Whether we should have paginated data.
     *
     * @var bool
     */
    protected $shouldPaginate = false;

    /**
     * Whether we should have paginated data.
     *
     * @return bool
     */
    public function shouldPaginate(): bool
    {
        // Do some computation or return a boolean
    }
}
```

There might be a possibility you want your data to be paginated but you don't want the pagination links to be shown, you can disable it by setting the protected $shouldDisplayPagination property to false. Or, you can add your own computed logic in the `shouldDisplayPagination` method as shown in the below example. Whatever is in the `shouldDisplayPagination` method will take precedence.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //...

    /**
     * Whether we should show the pagination links.
     *
     * @var bool
     */
    protected $shouldDisplayPagination = false;

    /**
     * Whether we should display the pagination links.
     *
     * @return bool
     */
    public function shouldDisplayPagination(): bool
    {
        // Do some computation or return a boolean
    }
}
```

If you are not getting your data from the `baseQuery` method or you don't want the laravel default pagination layout, you can override the `displayPagination` method to display the markup you want.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //...
    /**
     * Display the pagination links.
     *
     * @return string
     */
    public function displayPagination(): ?string
    {
        if (! $this->hasBaseQuery()) {
            throw QueryException::baseQueryMissing();
        }
        return $this->getData()->links();
    }
}
```

You can also control the default amount of items to display for a paginated list. Set the protected $paginationTotal property to an integer value. If it's set to null, then the laravel default total will be used. Or, you can add your own computed logic in the `getPaginationTotal` method as shown in the below example. Whatever is in the `getPaginationTotal` method will take precedence.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //...

    /**
     * The amount of items to be retrieved with pagination.
     *
     * @var bool
     */
    protected $paginationTotal = 25;

    /**
     * Get the paginated total.
     *
     * @return int|null
     */
    public function getPaginatedTotal(): ?int
    {
        // Do some computation or return an integer/null value
    }
}
```

If your data to display is not generated from the `baseQuery` method, you should override the protected `makePaginatedData` method to tell us how to paginate the data. The method receives an instance of the class as it's only argument and should return an iterable list, which will be used to display the current data.

```php
<?php

class PostsListingTable extends Laratables\BaseTable
{
    //...

    /**
     * Make the paginated data.
     *
     * @param  Laratables\BaseTable  $instance
     *
     * @return iterable
     */
    protected function makePaginatedData($instance): iterable
    {
        // User will have to define their paginated data list
        if (! $instance->hasBaseQuery()) {
            throw QueryException::baseQueryMissing();
        }

        if ($instance->hasPaginationTotal()) {
            return $instance->getQuery()->paginate($instance->getPaginationTotal());
        }

        return $instance->getQuery()->paginate();
    }
}
```



















## Active & Trash Sections

To indicate that you want an icon displayed to indicate that there is an active (none trash) section, set the `displayActiveSection` property to true.

To indicate that you want an icon displayed to indicate that there is a trash section, set the `displayTrashSection` property to true.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    /**
     * Whether to display the active section.
     */
    protected bool $displayActiveSection = true;

    /**
     * Whether to display the trash section.
     */
    protected bool $displayTrashSection = true;
}
```

By default, an image is used as the display icon. If you want to use an icon instead, set the `activeSectionVisualType` and `trashSectionVisualType` property to `icon`. By default, these would generate font awesome icons.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    /**
     * Indicate whether the active section visual should be an image or an icon.
     */
    protected string $activeSectionVisualType = 'icon';

    /**
     * Indicate whether the trash section visual should be an image or an icon.
     */
    protected string $trashSectionVisualType = 'icon';
}
```

If you don't have font awesome library configured, you can set your own icon markup. You can also set your own markup for the image visual.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    /**
     * Get the active section visual markup.
     *
     * @return string
     */
    public function getActiveSectionVisualMarkup(): string
    {
        if ($this->getActiveSectionVisualType() == 'icon') {
            return '<i class="fas fa-th-list"></i>';
        }
        if ($this->getTrashSectionVisualType() == 'image') {
            return '<img style="max-height: 100%; height: auto; max-width: 100%; width: auto;" src="'.asset('vendor/laratables/images/active-icon.png').'">';
        }
    }

    /**
     * Get the trash section visual markup.
     *
     * @return string
     */
    public function getTrashSectionVisualMarkup(): string
    {
        if ($this->getTrashSectionVisualType() == 'icon') {
            return '<i class="fas fa-trash-alt"></i>';
        }
        if ($this->getTrashSectionVisualType() == 'image') {
            return '<img style="max-height: 100%; height: auto; max-width: 100%; width: auto;" src="'.asset('vendor/laratables/images/trash-icon.png').'">';
        }
    }
}
```
