<?php

namespace Laratables\Traits;

trait Checkbox
{
    /**
     * Indicate whether checkboxes should be enabled at the start of the columns.
     */
    protected bool $hasCheckbox = false;

    /**
     * The name attribute for the checkbox.
     */
    protected string $checkboxName = 'laratables_checkbox';

    /**
     * The name of the item field, that is used to set the checkbox value.
     */
    protected string $idField = 'id';

    /**
     * Check whether checkbox is enabled.
     *
     * @return bool
     */
    public function hasCheckbox(): bool
    {
        return $this->hasCheckbox;
    }

    /**
     * Get the checkbox name.
     *
     * @return string
     */
    public function getCheckboxName(): string
    {
        return $this->checkboxName;
    }

    /**
     * Get the items id field.
     *
     * @return string
     */
    public function getIdField(): string
    {
        return $this->idField;
    }

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

    /**
     * Automatic filter for the checkbox output in the head section.
     *
     * NOTE:: As part of the standard functionality of this package, before
     * a Thead column title is rendered, a check is made to see if there
     * is a method provided to over ride the default title. All we are doing
     * here is taking advantage of that functionality.
     *
     * @param  string  $columnTitle
     * @param  int  $columnNumber
     * @param  string  $position
     *
     * @return string
     */
    protected function getCheckboxColumnTitle(string $columnTitle, int $columnNumber, string $position)
    {
        if ($position == 'head') {
            return $this->getHeadCheckboxMarkup($columnNumber);
        }
        if ($position == 'foot') {
            return $this->getFootCheckboxMarkup($columnNumber);
        }
        return null;
    }

    /**
     * Automatic filter for the checkbox in the body section.
     *
     * NOTE:: As part of the standard functionality of this package, before
     * a Tbody column content is rendered, a check is made to see if there
     * is a method provided to over ride the default content. All we are doing
     * here is taking advantage of that functionality.
     *
     * @param  mixed  $item
     * @param  int  $columnNumber
     * @param  int  $rowNumber
     *
     * @return string
     */
    protected function getCheckboxColumnContent($item, int $columnNumber, int $rowNumber)
    {
        return $this->getBodyCheckboxMarkup($item, $columnNumber, $rowNumber);
    }

    /**
     * Get the markup for the thead checkbox.
     *
     * @param  int  $columnNumber
     *
     * @return string
     */
    protected function getHeadCheckboxMarkup(int $columnNumber): string
    {
        $containerAttributes = $this->elementHtml('checkbox_parent')
            ->mergeElement('checkbox')
            ->override([
                'laratables-id' => 'checkbox-parent-container',
            ]);

        $checkboxAttributes = $this->elementHtml('checkbox_input_parent')
            ->mergeElement('checkbox_input')
            ->override([
                'laratables-id' => 'checkbox-parent',
                'type' => 'checkbox',
            ]);

        $content = "<div ".$containerAttributes.">";
        $content .= "<input ".$checkboxAttributes.">";
        $content .= "</div>";

        return $content;
    }

    /**
     * Get the markup for the tbody checkbox.
     *
     * @param  object  $item
     * @param  int  $columnNumber
     * @param  int  $rowNumber
     *
     * @return string
     */
    protected function getBodyCheckboxMarkup($item, int $columnNumber, int $rowNumber): ?string
    {
        $hasRowCheckbox = true;

        if (method_exists($this, $method = 'itemHasCheckbox')) {
            $hasRowCheckbox = $this->$method($item);
        }

        if (! $hasRowCheckbox) {
            return null;
        }

        $containerAttributes = $this->elementHtml('checkbox_child')
            ->mergeElement('checkbox')
            ->override([
                'laratables-id' => 'checkbox-child-container',
            ]);

        $checkboxAttributes = $this->elementHtml('checkbox_input_child')
            ->mergeElement('checkbox_input')
            ->override([
                'laratables-id' => 'checkbox-child',
                'type' => 'checkbox',
                'value' => $item->{$this->getIdField()},
                'name' => $this->getCheckboxName().'[]',
            ]);

        $content = "<div ".$containerAttributes.">";
        $content .= "<input ".$checkboxAttributes.">";
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
    protected function getFootCheckboxMarkup(int $columnNumber): string
    {
        $containerAttributes = $this->elementHtml('checkbox_parent')
            ->mergeElement('checkbox')
            ->override([
                'laratables-id' => 'checkbox-parent-container',
            ]);

        $checkboxAttributes = $this->elementHtml('checkbox_input_parent')
            ->mergeElement('checkbox_input')
            ->override([
                'laratables-id' => 'checkbox-parent',
                'type' => 'checkbox',
            ]);

        $content = "<div ".$containerAttributes.">";
        $content .= "<input ".$checkboxAttributes.">";
        $content .= "</div>";

        return $content;
    }
}
