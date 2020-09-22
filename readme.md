# Laratables

## Table Of Contents

1. [About](#about)
2. [Installation](#installation)
3. [Setup](#setup)
4. [Getting Started](#getting-started)
5. [Columns](#columns)
6. [Sortable Columns](#sortable-columns)
7. [Searchable Columns](#searchable-columns)
8. [Pagination](#pagination)
9. [Checkbox](#checkbox)
10. [Bulk Options](#bulk-options)
11. [Active & Trash Section](#sections)

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
        'title' => 'Title',
        'slug' => 'slug',
        'author' => 'Author',
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
        'title', 'slug',
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

To make columns searchable, define a `searchColumns` array property and list the ids of the columns that you want to be included in the search.

You can also customize the search key which will be used in the GET request for the search. Define a 'searchKey' property and set the value.

By default, a search field is not displayed. If you would like one generated for you, set the `displaySearch` property to true.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    // .....

    /**
     * The columns that are searchable.
     */
    protected array $searchColumns = [
        'title', 'slug',
    ];

    /**
     * The search key to use in the GET request.
     */
    protected string $searchKey = 'search';

    /**
     * Whether the search field should be displayed.
     */
    protected bool $displaySearch = true;
}
```
If for some reason, you are not happy with the way our search algorithm works, you should override the `handleSearchQuery` method with your own implementation. It accepts the search value as it's only argument.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    // ....

    /**
     * Handle the search query.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function handleSearchQuery($value)
    {
        // Use the getQuery() method to access the current build query ...

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

## Pagination

Pagination is enabled by default, but you can control some things in relation to it.

To customize the page, per page and page total used in the GET request, define a `pageKey`, `perPageKey` and `perPageTotal` property and set a value to it.

If you want to turn off pagination from your results, set the `shouldPaginate` property to false. Be very careful of this, as this will return your entire result set.

If you want to turn off the display of the pagination links, set the `shouldDisplayPagination` property to false.

Also, if you wish to have a per page dropdown list to toggle per page views, set the `shouldDisplayPerPageOptions` to true.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
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
}
```

## Checkbox

You can have checkboxes automatically generated by setting the `hasCheckbox` property to true.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    // ....

    /**
     * Whether checkboxes should be automatically generated.
     */
    protected bool $hasCheckbox = true;
}
```

## Bulk Options

Bulk options are a great feature of this package and it's really easy to work with. To enable bulk options, set the `displayBulkOptions` property to true.

Then, define a `getBulkOptions` method that returns an array of options.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    // ....

    /**
     * Whether bulk options should be displayed.
     *
     * @var bool
     */
    protected bool $displayBulkOptions = false;

    /**
     * Get the bulk options.
     *
     * Expected results is an array of associated arrays.
     *
     * Required are 'value' and 'title' with 'route', 'request_type' being
     * optional if you want us to automatically fire off the request for them.
     *
     * The 'route' will contain the route that the request should be fired off to.
     * The 'request_type' will contain the request method.
     *
     * @return array
     */
    public function getBulkOptions(): array
    {
        return [
            [
                'value' => 'restore',
                'title' => 'Restore',
                'route' => route('posts.bulk_restore')
                'request_type' => 'post',
            ],
            [
                'value' => 'delete',
                'title' => 'Delete Permanently',
                'route' => route('posts.bulk_delete')
                'request_type' => 'post',
            ],
        ];
    }
}
```

You will now be able to select bulk options. The request will be fired off to given route with the selected values. By default, the `id` field is used to set the value of the checkboxes. To change this, set the `idField` property to match your item id.

To also change the name of the field being submitted with the values, change the `checkboxName` property. It defaults as `laratables_checkbox`.

```php
<?php

namespace App\Tables;

class PostsListingTable extends Laratables\BaseTable
{
    // ....

    /**
     * The id field for the items being iterated over.
     */
    protected string $idField = 'id';

    /**
     * The name attribute for the checkbox.
     */
    protected string $checkboxName = 'laratables_checkbox';
}
```

## Sections

To display a visual for the active and trash sections, set the `displayActiveSection` and `displayTrashSection` property to true. In the case of the trash section, you will need to set the `disableTrash` property to false.

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

    /**
     * Whether to disable the trash section.
     */
    protected bool $disableTrash = false;
}
```

### Setting Data

### Base Query

### Display Footer

### Attributes

### Filter Output

getColumnTitle
get{ColumnId}ColumnTitle
get{ColumnId}HeadColumnTitle
get{ColumnId}Content
