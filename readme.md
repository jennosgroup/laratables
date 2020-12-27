# Laratables

## Table Of Contents

1. [About](#about)
2. [Installation](#installation)
3. [Setup](#setup)
4. [Getting Started](#getting-started)
5. [Table Data](#table-data)
    - [Data from database](#data-from-database)
    - [Custom Data Implementation](#custom-data-implementation)
6. [Columns](#columns)
    - [Defining table columns](#defining-table-columns)
    - [Column displayable content](#column-displayable-content)
    - [Customize column displayable content](#customize-column-displayable-content)
    - [Customize column title](#customize-column-title)
7. [Sortable Columns](#sortable-columns)
    - [Defining sortable columns](#defining-sortable-columns)
    - [Order and sort by key](#order-and-sort-by-key)
    - [Multiple sorting](#multiple-sorting)
    - [Sort icons](#sort-icons)
    - [Sort algorithm](#sort-algorithm)
8. [Searchable Columns](#searchable-columns)
    - [Defining search columns](#defining-search-column)
    - [Search key](#search-key)
    - [Display search field](#display-search-field)
    - [Search algorithm](#search-algorithm)
    - [Search icon markup](#search-icon-markup)
9. [Pagination](#pagination)
    - [Enable or disable pagination](#enable-or-disable-pagination)
    - [Display or hide pagination links](#display-or-hide-pagination-links)
    - [Display per page options](#display-per-page-options)
    - [Per page options](#per-page-options)
    - [Keys in GET request](#keys-in-get-request)
    - [Customize pagination view](#customize-pagination-view)
10. [Checkbox](#checkbox)
    - [Enable checkbox](#enable-checkbox)
    - [Checkbox value](#checkbox-value)
    - [Checkbox POST name](#checkbox-post-name)
    - [Row should have checkbox](#row-should-have-checkbox)
11. [Bulk Options](#bulk-options)
    - [Enable or disable](#enable-or-disable)
    - [Define bulk options](#define-bulk-options)
    - [Bulk action key](#bulk-action-key)
12. [Active & Trash Sections](#active-and-trash-sections)
    - [Show or Hide Sections](#show-or-hide-sections)
    - [Setting Current Section](#setting-current-section)
    - [Section Route](#section-route)
    - [Section Key in GET Request](#section-key-in-get-request)
    - [Section Visual Representation](#section-visual-representation)
13. [Actions](#actions)
    - [Enable or Disable Actions](#enable-or-disable-actions)
    - [Action Column Title](#action-column-title)
    - [Defining Actions](#defining-actions)
    - [Individual Item Actions](#individual-item-actions)
    - [Action UI](#action-ui)
    - [Supported And Custom Actions](#supported-and-custom-actions)
14. [Miscellaneous](#miscellaneous)
    - [No items message](#no-items-message)
    - [Show or hide Tfoot section](#show-or-hide-tfoot-section)

### About

Laratables is a laravel package that allows you to seemlessly generate html tables entirely using PHP classes.

### Installation

Install with composer `composer require jennosgroup/laratables`.

### Setup

Publish the package assets with artisan command `php artisan vendor:publish --tag=laratables-assets`.

Include the `laratables.js` script file in your html markup.

`<script src="{{ asset('vendor/laratables/js/laratables.js') }}" defer></script>`

The `laratables.js` file must be included for the tables to work as intended!

If you are going to create numerous html tables across your site that will share similar styles and features, it is best to create an abstract class and let all your other tables extend it.

### Getting Started

Create your class and extend the `Laratables\BaseTable` class.

```php
<?php

namespace App\Tables;

use App\Models\Post;
use Laratables\BaseTable;

class PostsTable extends BaseTable
{

}
```

Then in your controller, create an instance of the table by calling the static `make` method and passing it to your view. In your view file, include the `laratables::table` partial which is already setup to render your table based on your class definitions. It's that simple!


```php
<?php

namespace App\Http\Controllers;

class PostController extends Controller
{
    /**
     * Render the view for the posts listing.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $table = PostsTable::make();
        return view('posts.index', compact('table'));
    }
}
```

```html
@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    @include('laratables::table')
@endsection
```

### Table Data

##### Data From Database
The table will need data to work with. The default implementation is to fetch data from the database by way of laravel's query builder. Define a `baseQuery` method that holds your default query. Do not complete the query by calling `get` or `paginate` - this will be done automatically for you.

```php
/**
 * The base query to build upon.
 *
 * @return Illuminate\Database\Query\QueryBuilder
 */
protected function baseQuery()
{
    return Post::query();
}
```

##### Custom Data Implementation
If your data source is not from the database, you should override the `generateData` method with your own implementation of generating the data for the table to work with. The `generateData` method will only be called once.

```php
/**
 * Generate the data to work with.
 *
 * @param  Laratables\BaseTable  $instance
 *
 * @return iterable
 */
protected function generateData($instance): iterable
{
    return [
        [
            'id' => 1,
            'slug' => 'first-post',
            'title' => 'First Post',
        ],
        [
            'id' => 2,
            'slug' => 'second-post',
            'title' => 'third Post',
        ],
    ];
}
```

### Columns

##### Defining table columns

The table columns are defined in the `columns` property in array format. The array key is the column identifier while the array value is the column title.

If you want to perform some logic to determine what your columns are, you can override the `getColumns` method. To get a list of all the columns defined, call on the `getColumnsList` method, which will include the checkbox column if the checkbox feature is enabled.

```php
/**
 * The table columns.
 */
protected array $columns = [
    'title' => 'Title',
    'slug' => 'slug',
    'author' => 'Author',
];

/**
 * Get the table columns.
 *
 * @return array
 */
public function getColumns(): array
{
    return $this->getColumnsList();
}
```

##### Column displayable content

If your column id matches a field on your result item, the content of that field will automatically be displayed as the column content. For example, a column with id `slug` would call `$item->slug` automatically when rendering the column content. If your data is rendered from an array, it will call `$item['slug']`.

##### Customize column displayable content

To customize the column content, you can do it one of two ways.

One - by defining a `getColumnContent` method, which accepts four arguments.

```php
/**
 * Get the column content.
 *
 * @param  object|array  $item
 * @param  string  $columnId
 * @param  int  $columnNumber
 * @param  int  $rowNumber
 *
 * @return mixed
 */
public function getColumnContent($item, $columnId, $columnNumber, $rowNumber)
{
    if ($columnId == 'title') {
        return 'Post Title: '.$item->title;
    }
    return $item->{$columnId};
}
```

Or by setting a dynamic method `get{Id}ColumnContent`.

```php
/**
 * Get the column content.
 *
 * @param  object|array  $item
 * @param  int  $columnNumber
 * @param  int  $rowNumber
 *
 * @return mixed
 */
public function getTitleColumnContent($item, $columnNumber, $rowNumber)
{
    return 'Post Title: '.$item->title;
}
```

##### Customize column title

To customize the column title, you can do it one of two ways.

One - by defining a `getColumnTitle` method, which accepts four arguments.

```php
/**
 * Get the column title.
 *
 * @param  string  $columnId
 * @param  string  $columnTitle
 * @param  int  $columnNumber
 * @param  string  $position  Either 'head' or 'foot'
 *
 * @return mixed
 */
public function getColumnTitle($columnId, $columnTitle, $columnNumber, $position)
{
    if ($columnId == 'title') {
        return 'Post '.$columnTitle;
    }
    return $columnTitle;
}
```

Or by setting a dynamic method `get{Id}ColumnTitle`.

```php
/**
 * Get the column title.
 *
 * @param  string  $columnTitle
 * @param  int  $columnNumber
 * @param  string  $position  either 'head' or 'foot'
 *
 * @return mixed
 */
public function getSlugColumnTitle($columnTitle, $columnNumber, $position)
{
    return 'Post '.$columnTitle;
}
```

### Sortable Columns

##### Defining sortable columns

To make columns sortable, list the id of the columns that you wish to be sortable in the `sortColumns` property.

```php
/**
 * The sortable columns.
 */
protected array $sortColumns = [
    'title', 'slug',
];
```

##### Order and sort by key

You default order and sort key are `order` and `sort_by` respectively. In the event these clash with other $_GET request keys in your app, you can customize the keys. Define a `sortKey` and `orderKey` property and set the value you wish to use.

```php
/**
 * The sort by key, which holds the column/identifier to sort by.
 */
protected string $sortKey = 'sort_by';

/**
 * The order key which holds the 'asc' or 'desc' value.
 */
protected string $orderKey = 'order';
```

##### Multiple sorting

By default, multiple sorting is turned on. If you don't want multiple sorting, you can disable it by setting the `allowMultipleSorting` property to `false`.

```php

/**
 * Whether to allow multiple sorting.
 */
protected bool $allowMultipleSorting = false;
```

##### Sort icons

By default, the column sort icons used are svg based. To change this, you can define the markup for the respective `asc` and `desc` icon by overriding the `getAscSortIconMarkup` and `getDescSortIconMarkup` methods.

```php
/**
 * Get the asc sort icon markup.
 *
 * @return string
 */
public function getAscSortIconMarkup(): string
{
    return "<div class='flex'><img src='".asset('images/asc-icon.png')."'></div>";
}

/**
 * Get the desc sort icon markup.
 *
 * @return string
 */
public function getDescSortIconMarkup(): string
{
    return "<div class='flex'><img src='".asset('images/desc-icon.png')."'></div>";
}
```

##### Sort algorithm

NOTE: If you have implemented your own custom way of generating data through the `generateData` method, then you will have to do your own sorting in that very same method.

Sorting is enabled by default once you are having your data generated by defining a `baseQuery` method on your class.

If for some reason, you are not happy with the default sorting, you can creating your own algorithm by defining a `handleSortQuery` method, which is passed an array as it's only argument. The array contains the columns to be sorted as the array key, and their order (asc or desc) as the array value.

```php
/**
 * Handle the sort query.
 *
 * @param  array  $columns
 *
 * @return void
 */
protected function handleSortQuery(array $columns)
{
    foreach ($columns as $column => $order) {
        $this->getQuery()->orderBy(htmlspecialchars($column), $order);
    }
}
```

### Searchable Columns

##### Defining search columns

To make columns searchable, define a `searchColumns` array property and list the ids of the columns that you want to be included in the search.

```php
/**
 * The columns that are searchable.
 */
protected array $searchColumns = [
    'title', 'slug',
];
```

##### Search key

You can customize the search key used in the GET request. Define a 'searchKey' property and set the value.

```php
/**
 * The search key to use in the GET request.
 */
protected string $searchKey = 'search';
```

##### Display search field

By default, a search field is not displayed. If you would like one generated for you, set the `displaySearch` property to true.

```php
/**
 * Whether the search field should be displayed.
 */
protected bool $displaySearch = true;
```

##### Search algorithm

NOTE: If you have implemented your own custom way of generating data through the generateData method, then you will have to do your own searching in that very same method.

If for some reason, you are not happy with the way our search algorithm works, you should override the `handleSearchQuery` method with your own implementation. It accepts the search value as it's only argument.

```php
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
```

##### Search icon markup

You can override the existing search icon with the markup you want. Simply return the markup you want in the `getSearchIconMarkup` method.

```php
/**
 * Get the search icon markup.
 *
 * @return string
 */
public function getSearchIconMarkup(): string
{
    return "<div class='flex'><img src='".asset('images/search-icon.png')."'></div>";
}
```

### Pagination

##### Enable or disable pagination

NOTE: If your data is generated your own way through the `generateData` method, then pagination doesn't work out the box. You will have to implement your own paginated data list through the same method.

Pagination is enabled by default. To turn it off, set the `paginate` property to false. Be very careful of this, as this will display your entire result set.

```php
/**
 * Indicate whether we should paginate the query.
 */
protected bool $paginate = true;
```

##### Display or hide pagination links

By default, the pagination links are displayed if pagination is enabled. To hide the pagination links, set the `displayPagination` property to false.

```php
/**
 * Indicate whether we should display the pagination links.
 */
protected bool $displayPagination = false;
```

##### Display per page options

If you wish to have a per page dropdown list to toggle per page views, set the `displayPerPageOptions` to true.

```php
/**
 * Whether we should display the per page options.
 */
protected bool $displayPerPageOptions = false;
```

##### Per page options

By default, you can select to display 15, 25, 50 and 100 items per page. To change that, return an array list from the `getPerPageOptions` method.

```php
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
```

##### Keys in GET request

To customize the page, per page and total per page keys used in the $_GET request, define a `pageKey`, `perPageKey` and `perPageTotal` property and set a value to it.

```php
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
```

##### Customize pagination view

If you generated your own data and would like to customize the pagination markup, return the markup from a `displayPagination` method.

```php
/**
 * Display the pagination links.
 *
 * @return string|null
 */
public function displayPagination(): ?string
{
    return view('posts.pagination');

    // or

    return $this->getData()->withQueryString()->links();
}
```

### Checkbox

##### Enable checkbox

You can have checkboxes automatically generated by setting the `hasCheckbox` property to true. This will generate the checkbox as the first column.

```php
/**
 * Whether checkboxes should be automatically generated.
 */
protected bool $hasCheckbox = true;
```

##### Checkbox value

By default, the value assigned to the checkbox is taken from the `id` field of the item for the checkbox row. To change this, set the value of the `idField` property to match the field that contains the value for the checkbox to hold for submission.

```php
/**
 * The id field for the items being iterated over.
 */
protected string $idField = 'slug';
```

##### Checkbox POST name

The checkboxes are assigned the $_POST name of `laratables_checkbox`. To change this, set the value you want on the `checkboxName` property.

```php
/**
 * The name attribute for the checkbox.
 */
protected string $checkboxName = 'laratables_checkbox';
```

##### Row should have checkbox

There are instances where you might wish for one of your row item not to have a checkbox, while the others should. To filter this, perform your computation in the `itemHasCheckbox` method. It is passed the item as its only argument.

```php
/**
 * Filter if the individual row item has a checkbox.
 *
 * @param  mixed  $item
 *
 * @return bool
 */
public function itemHasCheckbox($item): bool
{
    return true;
}
```

### Bulk Options

##### Enable or disable

To enable bulk options, set the `displayBulkOptions` property to true.

```php
/**
 * Whether bulk options should be displayed.
 */
protected bool $displayBulkOptions = true;
```

##### Define bulk options

NOTE: The checkbox feature plays a part in the bulk options. When a bulk request is fired off, the values from the checkboxes are sent with the request.

Define a `getBulkOptions` method that returns an array of array options. Each array should have `title`, `value`, `route` and `request_type` keys.

The `value` key is the bulk action name.

The `title` key is the displayable name of the action.

The `route` key is the route to send the bulk request to.

The `request_type` key is the type of HTTP request to fire.

```php
/**
 * Get the bulk options.
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
```

##### Bulk action key

The key used to identify the bulk action is `bulk_action`. To change this, define a `bulkActionKey` property and set a value.

```php
/**
 * The key for the bulk action.
 */
protected string $bulkActionKey = 'bulk_action';
```

### Active and Trash Sections

##### Show or Hide Sections

To display a UI (clickable area) for the active and trash sections, set the `displayActiveSection` and `displayTrashSection` property to true. In the case of the trash section, you will need to set the `disableTrash` property to false.

```php
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
```

##### Setting Current Section

To set the current section that the table is on, set `active` or `trash` on the `currentSection` property

```php
/**
 * The section that is current. 'active' and 'trash' is reserved by us.
 */
protected string $currentSection = 'active';
```

##### Section Route

We will need routes for the section, so that when the visual representation is clicked, the user is taken to the route. To define the route, return the route value on the `getActiveSectionRoute` and `getTrashSectionRoute` method.

```php
/**
 * Get the route for the active section.
 *
 * @return string
 */
public function getActiveSectionRoute(): string
{
    return route('posts.index', ['section' => 'active']);
}

/**
 * Get the route for the trash section.
 *
 * @return string
 */
public function getTrashSectionRoute(): string
{
    return route('posts.index', ['section' => 'trash']);
}
```

##### Section Key in GET Request

The key used in the get request is `section`. To change this, set a value on the `sectionKey` property.

```php
/**
 * The key for the section used in the $_GET request..
 */
protected string $sectionKey = 'section';
```

##### Section Visual Representation

We can determine whether we want the sections to be visually represented by an icon or an image. set the `activeSectionVisualType` and `trashSectionVisualType` to `icon` or `image`.

```php
/**
 * Indicate whether the active section visual should be an image or an icon.
 */
protected string $activeSectionVisualType = 'icon';

/**
 * Indicate whether the trash section visual should be an image or an icon.
 */
protected string $trashSectionVisualType = 'icon';
```

We can also customize the markup for the icon/image.

```php
/**
 * Get the active section icon markup.
 *
 * @return string
 */
public function getActiveSectionIconMarkup(): string
{
    return '<i class="fas fa-th-list laratables-section-icon laratables-active-section-icon"></i>';
}

/**
 * Get the active section image markup.
 *
 * @return string
 */
public function getActiveSectionImageMarkup(): string
{
    return "<div class='flex'><img src='".asset('images/active-section-image.png')."'></div>";
}

/**
 * Get the trash section icon markup.
 *
 * @return string
 */
public function getTrashSectionIconMarkup(): string
{
    return '<i class="fas fa-trash-alt laratables-section-icon laratables-trash-section-icon"></i>';
}

/**
 * Get the trash section image markup.
 *
 * @return string
 */
public function getTrashSectionImageMarkup(): string
{
    return "<div class='flex'><img src='".asset('images/trash-section-image.png')."'></div>";
}
```

### Actions

##### Enable or Disable Actions

By default, actions column is disabled. To automatically generate the actions column, set the `hasActions` property to true. Set the value to false to disable it.

```php
/**
 * If we should automatically handle the actions column.
 */
protected bool $hasActions = true;
```

##### Action Column Title

The default title for the actions column is `Actions`. To change this, set a value to the `actionColumnTitle` property.

```php
/**
 * The title for the action column.
 */
protected string $actionColumnTitle = 'Tasks';
```

##### Defining Actions

To define a list of actions to be automatically generated, on the `actions` property, set an array of options.

```php
/**
 * The list of action types that is needed.
 */
protected array $actions = [
    'view' => ['routeName' => 'posts.show', 'method' => 'get'],
    'edit' => ['routeName' => 'posts.edit', 'method' => 'get'],
    'delete' => ['routeName' => 'posts.destroy', 'method' => 'delete'],
];
```

As seen above, The initial array key defined, is the text that will be displayed for the action. A route name is required, as the row item will be passed to laravel's route function like this `route($routeName, $item)`. When the action is clicked, a request will be fired off to the generated route. The request type that will be used is the one set in the `method` key. The required `csrf_token` and `method spoofing` will be taken care of automatically.

##### Individual Item Actions

By default, the actions defined in the `actions` property will apply to all rows generated by the table. To individually set actions for a given item, use the `getItemActions` method. It receives the `$item` as it's only argument.

```php
/**
 * Get the action for an individual item.
 *
 * @param  mixed  $item
 *
 * @return array
 */
public function getItemActions($item): array
{
    $protectedSlugs = config('app.protected_post_slugs');

    if (in_array($item->slug, $protectedSlugs)) {
        return [];
    }

    return $this->getActions();
}
```

##### Action UI

The actions representation can either be a link or button. It's default is a link. To change this, set the `actionDisplayType` property to `link` or `button`.

```php
/**
 * The action type.
 *
 * Accepts 'button' or 'link'.
 */
protected string $actionDisplayType = 'link';
```

The visual representation for the action can be either text or icon. To change this, set the `actionContentType` property to `icon` or `text`.

```php
/**
 * The type of content for the action.
 *
 * Accepts 'text' or 'icon'.
 */
protected string $actionContentType = 'text';
```

##### Supported And Custom Actions

By default, support is granted for `view`, `edit`, `trash`, `restore` and `delete` action. This means `icon` and `text` support is already configured.

Other actions can be supported.

To support `text` actions, define a `get{Action}ActionText` method which should return a string representing the text.

```php
/**
 * Get the email action text.
 *
 * @return string|null
 */
public function getEmailActionText(): ?string
{
    return 'email';
}
```

To support 'icon' actions, define a `get{Icon}ActionIconMarkup` method which should return the markup for the icon i.e image or svg html.

```php
/**
 * Get the action icon markup.
 *
 * @return string|null
 */
public function getEmailActionIconMarkup(): ?string
{
    return "<div class='flex'><img src='".asset('images/email-action-icon.png')."'></div>";
}
```

### Miscellaneous

##### No items message

By default, when no items are available for display, a message is displayed indicating such. To customize the exact message, set a value on the `noItemsMessage` property.


```php
/**
 * The no items message.
 */
protected string $noItemsMessage = 'There is nothing to display.';
```

##### Show or hide Tfoot section

By default, the table tfoot section is displayed. To change this behaviour, set the `displayTfoot` property to false.

```php
/**
 * Indicate whether the table footer should be displayed.
 */
protected bool $displayTfoot = true;
```
