<?php

namespace Laratables\Traits;

trait Checkbox
{
    /**
     * Indicate whether checkboxes should be enabled at the start of the columns.
     */
    protected bool $hasCheckbox = false;

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
     * Get the identifier to target when we want to detect that we should check
     * all the checkboxes, when the checkbox is checked in the head/foot section
     *
     * @return string
     */
    public function getParentCheckboxIdentifier(): string
    {
        return ".laratables-parent-checkbox";
    }

    /**
     * Get the identifier to target when we want to detect which checkboxes in the
     * tbody are checked.
     *
     * @return string
     */
    public function getBodyCheckboxIdentifier(): string
    {
        return ".laratables-child-checkbox";
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
        $content = "<div class='laratables-checkbox-container laratables-top-checkbox-container laratables-checkbox-parent-container'>";
        $content .= "<input type='checkbox' class='laratables-checkbox laratables-top-checkbox laratables-parent-checkbox'>";
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
        $content = "<div class='checkbox-container checkbox-child-container'>";
        $content .= '<input type="checkbox" name="laratables_checkbox[]" value="'.$this->escape($item->{$this->getIdField()}).'" class="laratables-checkbox laratables-child-checkbox">';
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
        $content = "<div class='laratables-checkbox-container laratables-bottom-checkbox-container laratables-checkbox-parent-container'>";
        $content .= "<input type='checkbox' class='laratables-checkbox laratables-bottom-checkbox laratables-parent-checkbox'>";
        $content .= "</div>";

        return $content;
    }
}
