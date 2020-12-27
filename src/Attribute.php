<?php

namespace Laratables;

use Illuminate\Support\Str;
use Laratables\Exceptions\AttributeException;

class Attribute
{
    /**
     * The table we are working with.
     */
    private ?BaseTable $table;

    /**
     * The element to get the attributes for.
     */
    private ?string $element = null;

    /**
     * The list of attributes to merge.
     */
    private array $merge = [];

    /**
     * The elements to merge.
     */
    private array $mergeElement = [];

    /**
     * The default list of attributes to add if they don't exist.
     */
    private array $defaults = [];

    /**
     * The list of attributes to exclude.
     */
    private array $except = [];

    /**
     * The list of attributes to over ride.
     */
    private array $override = [];

    /**
     * Set the table we are working with.
     *
     * @param  Laratables\BaseTable  $table
     *
     * @return $this
     */
    public function table(BaseTable $table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Set the element.
     *
     * @param  string  $element
     *
     * @return $this
     */
    public function element(string $element): self
    {
        $this->element = $element;
        return $this;
    }

    /**
     * Set the attributes to merge.
     *
     * @param  array  $attributes
     *
     * @return $this
     */
    public function merge(array $attributes): self
    {
        $this->merge = $attributes;
        return $this;
    }

    /**
     * The element to merge.
     *
     * @param  array|string  $elements
     *
     * @return $this
     */
    public function mergeElement($elements): self
    {
        if (! is_array($elements)) {
            $elements = func_get_args();
        }

        foreach ($elements as $element) {
            $this->mergeElement[] = $element;
        }

        return $this;
    }

    /**
     * Set the default attributes.
     *
     * @param  array  $attributes
     *
     * @return $this
     */
    public function defaults(array $attributes): self
    {
        $this->defaults = $attributes;
        return $this;
    }

    /**
     * Set the attributes to exempt from the results.
     *
     * @param  array  $attributes
     *
     * @return $this
     */
    public function except(array $attributes): self
    {
        $this->except = $attributes;
        return $this;
    }

    /**
     * Set the attributes to over ride what has already been set.
     *
     * @param  array  $attributes
     *
     * @return $this
     */
    public function override(array $attributes): self
    {
        $this->override = $attributes;
        return $this;
    }

    /**
     * Generate the attributes string.
     *
     * @return string
     */
    public function execute(): string
    {
        if (is_null($this->table)) {
            throw AttributeException::tableMissing(get_class($this));
        }

        if (is_null($this->element)) {
            throw AttributeException::elementMissing(get_class($this));
        }

        $attributes = $this->getElementAttributes();

        // Merge the attributes
        if (! empty($this->merge)) {
            $attributes = $this->mergeAttributes($attributes, $this->merge);
        }

        // Merge the elements attributes
        if (! empty($this->mergeElement)) {

            $mergeElements = array_unique($this->mergeElement);

            foreach ($mergeElements as $mergeElement) {
                $elementAttributes = $this->table->getElementAttributes($mergeElement);
                $attributes = $this->mergeAttributes($attributes, $elementAttributes);
            }
        }

        // Over ride any previous attributes
        if (! empty($this->override)) {
            $attributes = $this->mergeAttributes($attributes, $this->override, true);
        }

        $attributes = array_merge($this->defaults, $attributes);
        $attributes = array_diff_key($attributes, array_flip($this->except));

        return $this->table->parseAttributesForOutput($attributes);
    }

    /**
     * Get the element attributes.
     *
     * @return array
     */
    private function getElementAttributes(): array
    {
        $method = 'get'.Str::studly($this->element).'Attributes';

        // Check if any custom methods are available with attributes.
        if (method_exists($this->table, $method)) {
            return $this->table->$method();
        }

        return $this->table->getElementAttributes($this->element);
    }

    /**
     * Merge some attributes.
     *
     * @param  array  $attributes
     * @param  array  $newAttributes
     * @param  bool  $override
     *
     * @return array
     */
    private function mergeAttributes(array $attributes, array $newAttributes, bool $override = false): array
    {
        foreach ($newAttributes as $attribute => $value) {
            if (array_key_exists($attribute, $attributes) && ! $override) {
                $attributes[$attribute] = $attributes[$attribute].' '.$value;
            } else {
                $attributes[$attribute] = $value;
            }
        }

        return $attributes;
    }

    /**
     * Generate the attributes string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->execute();
    }
}
