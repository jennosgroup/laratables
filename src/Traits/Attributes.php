<?php

namespace Laratables\Traits;

trait Attributes
{
    /**
     * The attributes storage.
     *
     * @var array
     */
    protected array $attributes = [
        'wrapper' => [],
        'container' => [],
        'table' => [],
        'thead' => [],
        'thead_tr' => [],
        'thead_th' => [],
        'tbody' => [],
        'tbody_tr' => [],
        'tbody_tr_no_items' => [],
        'tbody_td' => [],
        'tbody_td_no_items' => [],
        'tfoot' => [],
        'tfoot_tr' => [],
        'tfoot_th' => [],
        'top_wrapper_top' => [],
        'top_wrapper_middle' => [],
        'top_wrapper_bottom' => [],
        'bottom_wrapper_top' => [],
        'bottom_wrapper_middle' => [],
        'bottom_wrapper_bottom' => [],
        'top_wrapper_middle_left_column' => [],
        'top_wrapper_middle_right_column' => [],
        'bulk_container' => [],
        'per_page_container' => [],
        'active_section_container' => [],
        'trash_section_container' => [],
        'search_container' => [],
        'bulk_options_select' => [],
        'per_page_select' => [],
        'search_input' => [],
        'search_submit' => [],
        'sort_button' => [],
    ];

    /**
     * The custom attributes that will be merged into the attributes.
     */
    protected array $customAttributes = [];

    /**
     * Get element attributes for output as one string.
     *
     * @param  string  $element
     *
     * @return string|null
     */
    public function getElementAttributesString(string $element, array $attributes = [], array $except = [], bool $override = false): ?string
    {
        if (! empty($attributes) || ! empty($except)) {
            return $this->getAndMergeElementAttributesString($element, $attributes, $except, $override);
        }

        return $this->parseAttributesForOutput(
            $this->getElementAttributes($element)
        );
    }

    /**
     * Get the element attributes with defaults if certain attributes don't exist.
     *
     * @param  string  $element
     * @param  array  $defaults
     * @param  array  $except
     *
     * @return string|null
     */
    public function getElementAttributesStringWithDefaults(string $element, array $defaults = [], array $except = []): ?string
    {
        $attributes = $this->getElementAttributes($element);

        if (empty($attributes)) {
            return $this->parseAttributesForOutput($defaults);
        }

        // Remove the attribute we don't want to fetch
        foreach ($except as $value) {
            if (array_key_exists($value, $attributes)) {
                unset($attributes[$value]);
            }
        }

        foreach ($defaults as $defaultAttribute => $defaultValue) {
            if (! array_key_exists($defaultAttribute, $attributes)) {
                $attributes[$defaultAttribute] = $defaultValue;
            }
        }

        return $this->parseAttributesForOutput($attributes);
    }

    /**
     * Get and merge element attributes for output as one string.
     *
     * @param  string  $element
     * @param  array  $attributes
     * @param  array  $except
     * @param  bool  $override
     *
     * @return string|null
     */
    public function getAndMergeElementAttributesString(string $element, array $attributes, array $except = [], bool $override = false): ?string
    {
        return $this->parseAttributesForOutput(
            $this->getAndMergeElementAttributes($element, $attributes, $except, $override)
        );
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        if ($attributes = $this->cache->get('attributes')) {
            return $attributes;
        }

        $attributes = $this->attributes;
        $customAttributes = $this->customAttributes;

        foreach ($customAttributes as $element => $customAttribute) {
            foreach ($customAttribute as $attribute => $value) {
                $attributes[$element][$attribute] = $value;
            }
        }

        $this->cache->put('attributes', $attributes, 0);

        return $attributes;
    }

    /**
     * Get element attributes.
     *
     * @param  string  $element
     *
     * @return array
     */
    public function getElementAttributes(string $element): array
    {
        $attributes = $this->getAttributes();
        return $attributes[$element] ?? [];
    }

    /**
     * Get the element attribute.
     *
     * @param  string  $element
     * @param  string  $attribute
     *
     * @return string|null
     */
    public function getElementAttribute(string $element, string $attribute): ?string
    {
        $attributes = $this->getAttributes()[$element][$attribute] ?? null;

        if (is_null($attributes)) {
            return null;
        }

        $attributes = explode(' ', $attributes);

        return implode(' ', array_unique($attributes));
    }

    /**
     * Add attribute to an element.
     *
     * @param  string  $element
     * @param  string  $attribute
     * @param  string  $value
     *
     * @return $this
     */
    protected function addElementAttribute(string $element, string $attribute, string $value, bool $override = false): self
    {
        $attributes = $this->getAndMergeElementAttribute(
            $element, $attribute, $value, [], $override
        );

        $this->attributes[$element][$attribute] = $attributes;

        $this->cache->forget('attributes');

        return $this;
    }

    /**
     * Add attributes to an element.
     *
     * @param  string  $element
     * @param  array  $attributes
     * @param  bool  $override
     *
     * @return $this
     */
    protected function addElementAttributes(string $element, array $attributes, bool $override = false): self
    {
        foreach ($attributes as $attribute => $value) {
            $this->addElementAttribute($element, $attribute, $value, $override);
        }
        return $this;
    }

    /**
     * Get the existing element attribute, and merge a new value with it, and
     * return the new value.
     *
     * @param  string  $element
     * @param  string  $attribute
     * @param  string  $value
     * @param  array  $except
     * @param  bool  $override
     *
     * @return string|null
     */
    public function getAndMergeElementAttribute(string $element, string $attribute, string $value = null, array $except = [], bool $override = false): ?string
    {
        if (! $this->elementAttributeExists($element, $attribute)) {
            return $value;
        }

        if ($override) {
            return $value;
        }

        $values = $this->getElementAttribute($element, $attribute);
        $values = explode(' ', $values);

        foreach ($values as $index => $oldValue) {
            if (in_array($oldValue, $except)) {
                unset($values[$index]);
            }
        }

        if (empty($values)) {
            return $value;
        }

        if (is_null($value) || $value == '') {
            return implode(' ', $values);
        }

        $values[] = $value;

        return implode(' ', array_unique($values));
    }

    /**
     * Get the existing element attributes, and merge a new list with them, and
     * return the new modified list.
     *
     * @param  string  $element
     * @param  array  $newAttributes
     * @param  array  $except
     * @param  bool  $override
     *
     * @return array
     */
    public function getAndMergeElementAttributes(string $element, array $newAttributes, array $except = [], bool $override = false): array
    {
        $attributes = $this->getElementAttributes($element);

        return $this->mergeAttributes($attributes, $newAttributes, $except, $override);
    }

    /**
     * Merge a list of attributes.
     *
     * @param  array  $attributes
     * @param  array  $newAttributes
     * @param  array  $except
     * @param  bool  $override
     *
     * @return array
     */
    public function mergeAttributes(array $attributes, array $newAttributes, array $except = [], bool $override = false): array
    {
        foreach ($newAttributes as $attribute => $value) {

            // This attribute isn't needed back from the original list
            if (in_array($attribute, $except)) {
                unset($attributes[$attribute]);
            }

            if (is_null($value) || $value == '') {
                continue;
            }

            // Add new attribute into the old list if it didn't exist there
            if (! isset($attributes[$attribute])) {
                $attributes[$attribute] = $value;
                continue;
            }

            if ($override) {
                $existing = $value;
            } else {
                $existing = $attributes[$attribute].' '.$value;
            }

            $attributes[$attribute] = implode(' ', array_unique(explode(' ', $existing)));
        }

        return $attributes;
    }

    /**
     * Check whether attributes exists.
     *
     * @return bool
     */
    public function hasAttributes(): bool
    {
        return ! empty($this->getAttributes());
    }

    /**
     * Check whether an element has attributes.
     *
     * @param  string  $element
     *
     * @return bool
     */
    public function elementHasAttributes(string $element): bool
    {
        return isset($this->getAttributes()[$element]);
    }

    /**
     * Check whether an element attribute exists.
     *
     * @param  string  $element
     * @param  string  $attribute
     *
     * @return bool
     */
    public function elementAttributeExists(string $element, string $attribute): bool
    {
        return isset($this->getAttributes()[$element][$attribute]);
    }

    /**
     * Remove all the attributes from an element.
     *
     * @param  string  $element
     *
     * @return $this
     */
    protected function removeElementAttributes(string $element): self
    {
        unset($this->getAttributes()[$element]);
        return $this;
    }

    /**
     * Remove an element attribute.
     *
     * @param  string  $element
     * @param  string  $attribute
     *
     * @return $this
     */
    protected function removeElementAttribute(string $element, string $attribute): self
    {
        unset($this->getAttributes()[$element][$attribute]);
        return $this;
    }

    /**
     * Parse a list of attributes for output as one string.
     *
     * @param  array  $attributes
     *
     * @return string
     */
    public function parseAttributesForOutput(array $attributes): string
    {
        $results = [];

        foreach ($attributes as $attribute => $value) {
            $results[] = $this->parseAttributeForOutput($attribute, $value);
        }

        return implode(' ', $results);
    }

    /**
     * Parse an attribute pair for output.
     *
     * @param  string  $attribute
     * @param  string|array  $value
     *
     * @return string
     */
    public function parseAttributeForOutput(string $attribute, $value): string
    {
        if (is_array($value)) {
            $value = implode(' ', array_unique($value));
        } else {
            $value = implode(' ', array_unique(explode(' ', $value)));
        }

        return $attribute."='".$value."'";
    }
}
