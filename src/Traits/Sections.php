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
     * The key for the section.
     */
    protected string $sectionKey = 'section';

    /**
     * The class to use for the current section.
     */
    protected string $currentSectionClass;

    /**
     * The class to use for the non current section.
     */
    protected string $nonCurrentSectionClass;

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
        if ($this->getActiveSectionVisualType() == 'image') {
            return '<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-section-icon view-list"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>';
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
            return '<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-section-icon trash"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
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
     * Get the section key.
     *
     * @return string
     */
    public function getSectionKey(): string
    {
        return $this->sectionKey;
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

    /**
     * Get the non current section class.
     *
     * @return string|null
     */
    public function getNonCurrentSectionClass(): ?string
    {
        return $this->nonCurrentSectionClass;
    }
}
