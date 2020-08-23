<?php

namespace Laratables\Traits;

trait Sections
{
    /**
     * Whether to display the active section.
     */
    protected bool $displayActiveSection = false;

    /**
     * Whether to display the trash section.
     */
    protected bool $displayTrashSection = false;

    /**
     * Whether to disable the trash section.
     */
    protected bool $disableTrash = true;

    /**
     * Indicate whether the active section visual should be an image or an icon.
     */
    protected string $activeSectionVisualType = 'image';

    /**
     * Indicate whether the trash section visual should be an image or an icon.
     */
    protected string $trashSectionVisualType = 'image';

    /**
     * The section that is current. Only accepts 'active' or 'trash'.
     */
    protected string $currentSection = 'active';

    /**
     * The class to use for the current section.
     */
    protected string $currentSectionClass = 'section-current';

    /**
     * Check if the active section should be displayed.
     *
     * @return bool
     */
    public function shouldDisplayActiveSection(): bool
    {
        return $this->displayActiveSection;
    }

    /**
     * Check if the trash section should be displayed.
     *
     * @return bool
     */
    public function shouldDisplayTrashSection(): bool
    {
        return $this->displayTrashSection;
    }

    /**
     * Check if the trash section is enabled.
     *
     * @return bool
     */
    public function trashIsDisabled(): bool
    {
        return $this->disableTrash;
    }

    /**
     * Check if the trash is enabled.
     *
     * @return bool
     */
    public function trashIsEnabled(): bool
    {
        return $this->trashIsDisabled() === false;
    }

    /**
     * Get the active section visual type.
     *
     * @return string
     */
    public function getActiveSectionVisualType(): string
    {
        return $this->activeSectionVisualType;
    }

    /**
     * Get the trash section visual type.
     *
     * @return string
     */
    public function getTrashSectionVisualType(): string
    {
        return $this->trashSectionVisualType;
    }

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

    /**
     * Get the section that is current.
     *
     * @return string
     */
    public function getCurrentSection(): string
    {
        return $this->currentSection;
    }

    /**
     * Get the route for the active section.
     *
     * @return string
     */
    public function getActiveSectionRoute(): string
    {
        return '';
    }

    /**
     * Get the route for the trash section.
     *
     * @return string
     */
    public function getTrashSectionRoute(): string
    {
        return '';
    }

    /**
     * Get the current section class.
     *
     * @return string|null
     */
    public function getCurrentSectionClass(): ?string
    {
        return $this->currentSectionClass;
    }
}
