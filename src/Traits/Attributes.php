<?php

namespace Laratables\Traits;

use Laratables\Attribute;

trait Attributes
{
    /**
     * The attributes storage.
     */
    protected array $attributes = [
        'wrapper' => [],
        'top_wrapper_top' => [],
        'top_wrapper_middle' => [],
        'top_wrapper_bottom' => [],
        'bottom_wrapper_top' => [],
        'bottom_wrapper_middle' => [],
        'bottom_wrapper_bottom' => [],
        'top_wrapper_middle_left_column' => [],
        'top_wrapper_middle_right_column' => [],
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
        'wrapper_selects' => [],
        'bulk' => [],
        'bulk_options_select' => [],
        'per_page' => [],
        'per_page_select' => [],
        'section' => [],
        'active_section' => [],
        'trash_section' => [],
        'active_section_current' => [],
        'trash_section_current' => [],
        'active_section_not_current' => [],
        'trash_section_not_current' => [],
        'search' => [],
        'search_input' => [],
        'search_submit' => [],
        'column_title' => [],
        'column_title_content' => [],
        'column_title_form' => [],
        'column_sort_button' => [],
        'checkbox' => [],
        'checkbox_parent' => [],
        'checkbox_child' => [],
        'checkbox_input' => [],
        'checkbox_input_parent' => [],
        'checkbox_input_child' => [],
        'actions' => [],
        'actions_button' => [],
        'actions_link' => [],
        'view_action_button' => [],
        'edit_action_button' => [],
        'trash_action_button' => [],
        'restore_action_button' => [],
        'delete_action_button' => [],
        'view_action_link' => [],
        'edit_action_link' => [],
        'trash_action_link' => [],
        'restore_action_link' => [],
        'delete_action_link' => [],
    ];

    /**
     * The list of attributes that will be merged with others.
     */
    protected array $masterAttributes = [];

    /**
     * A fluent builder for getting the element attributes as a string for the html.
     *
     * @param  string  $element
     *
     * @return Laratables\Attribute
     */
    public function elementHtml(string $element): Attribute
    {
        $attribute = new Attribute;
        return $attribute->table($this)->element($element);
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
        $masterAttributes = $this->masterAttributes;

        foreach ($masterAttributes as $element => $masterAttributesList) {
            foreach ($masterAttributesList as $attribute => $value) {

                $currentAttributes = $attributes[$element][$attribute] ?? null;

                if (empty($currentAttributes)) {
                    $attributes[$element][$attribute] = $value;
                } else {
                    $attributes[$element][$attribute] = implode(' ', array_unique(explode(' ', $currentAttributes.' '.$value)));
                }
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
}
