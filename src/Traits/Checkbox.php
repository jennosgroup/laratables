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
     * Automatic filter for the checkbox output in the head section.
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
        $containerAttributes = $this->getElementAttributes('checkbox_parent');
        $containerAttributes = $this->getAndMergeElementAttributes('checkbox', $containerAttributes);
        $containerAttributes['laratables-id'] = 'checkbox-parent-container';

        $checkboxAttributes = $this->getElementAttributes('checkbox_input_parent');
        $checkboxAttributes = $this->getAndMergeElementAttributes('checkbox_input', $checkboxAttributes);
        $checkboxAttributes['laratables-id'] = 'checkbox-parent';
        $checkboxAttributes['type'] = 'checkbox';

        $content = "<div ".$this->parseAttributesForOutput($containerAttributes).">";
        $content .= "<input ".$this->parseAttributesForOutput($checkboxAttributes).">";
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
    protected function getBodyCheckboxMarkup($item, int $columnNumber, int $rowNumber): string
    {
        $containerAttributes = $this->getElementAttributes('checkbox_child');
        $containerAttributes = $this->getAndMergeElementAttributes('checkbox', $containerAttributes);
        $containerAttributes['laratables-id'] = 'checkbox-child-container';

        $checkboxAttributes = $this->getElementAttributes('checkbox_input_child');
        $checkboxAttributes = $this->getAndMergeElementAttributes('checkbox_input', $checkboxAttributes);
        $checkboxAttributes['laratables-id'] = 'checkbox-child';
        $checkboxAttributes['type'] = 'checkbox';
        $checkboxAttributes['value'] = $item->{$this->getIdField()};
        $checkboxAttributes['name'] = $this->getCheckboxName().'[]';

        $content = "<div ".$this->parseAttributesForOutput($containerAttributes).">";
        $content .= "<input ".$this->parseAttributesForOutput($checkboxAttributes).">";
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
        $containerAttributes = $this->getElementAttributes('checkbox_parent');
        $containerAttributes = $this->getAndMergeElementAttributes('checkbox', $containerAttributes);
        $containerAttributes['laratables-id'] = 'checkbox-parent-container';

        $checkboxAttributes = $this->getElementAttributes('checkbox_input_parent');
        $checkboxAttributes = $this->getAndMergeElementAttributes('checkbox_input', $checkboxAttributes);
        $checkboxAttributes['laratables-id'] = 'checkbox-parent';
        $checkboxAttributes['type'] = 'checkbox';

        $content = "<div ".$this->parseAttributesForOutput($containerAttributes).">";
        $content .= "<input ".$this->parseAttributesForOutput($checkboxAttributes).">";
        $content .= "</div>";

        return $content;
    }
}
