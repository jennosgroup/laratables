<?php

namespace Laratables\Traits;

trait BulkOptions
{
    /**
     * Whether bulk options should be displayed.
     */
    protected bool $displayBulkOptions = false;

    /**
     * The key for the bulk action.
     */
    protected string $bulkActionKey = 'bulk_action';

    /**
     * Whether bulk options should be displayed.
     *
     * @return bool
     */
    public function shouldDisplayBulkOptions(): bool
    {
        return $this->displayBulkOptions;
    }

    /**
     * Get the bulk action key.
     *
     * @return string
     */
    public function getBulkActionKey(): string
    {
        return $this->bulkActionKey;
    }

    /**
     * Get the bulk select attributes string.
     *
     * @return string
     */
    public function getBulkSelectAttributesString(): string
    {
        $attributes = $this->getElementAttributes('bulk_options_select');
        $attributes = $this->getAndMergeElementAttributes('wrapper_selects', $attributes);
        $attributes['name'] = $this->getBulkActionKey();
        $attributes['laratables-id'] = 'bulk-options-select';

        return $this->parseAttributesForOutput($attributes);
    }

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
        return [];
    }
}
