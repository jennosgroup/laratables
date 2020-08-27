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
     * The section that is current. 'active' and 'trash' is reserved by us.
     */
    protected string $currentSection = 'active';

    /**
     * The key for the section used in the $_GET request..
     */
    protected string $sectionKey = 'section';

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
     * @return string|null
     */
    public function getActiveSectionVisualMarkup(): ?string
    {
        if ($this->getActiveSectionVisualType() == 'icon') {
            return $this->getActiveSectionIconMarkup();
        }
        if ($this->getActiveSectionVisualType() == 'image') {
            return $this->getActiveSectionImageMarkup();
        }
        return null;
    }

    /**
     * Get the trash section visual markup.
     *
     * @return string|null
     */
    public function getTrashSectionVisualMarkup(): ?string
    {
        if ($this->getTrashSectionVisualType() == 'icon') {
            return $this->getTrashSectionIconMarkup();
        }
        if ($this->getTrashSectionVisualType() == 'image') {
            return $this->getTrashSectionImageMarkup();
        }
        return null;
    }

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
        return '<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-section-icon laratables-active-section-icon"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>';
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
        return '<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-section-icon laratables-trash-section-icon"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
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
     * Get the section key to use in the $_GET request.
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
        return '#';
    }

    /**
     * Get the route for the trash section.
     *
     * @return string
     */
    public function getTrashSectionRoute(): string
    {
        return '#';
    }

    /**
     * Get the active section attributes string.
     *
     * @return string
     */
    public function getActiveSectionAttributesString(): string
    {
        $attributes = $this->getActiveSectionAttributes();
        $attributes['href'] = $this->getActiveSectionRoute();
        $attributes['laratables-section'] = 'active';
        $attributes['laratables-section-active'] = ($this->getCurrentSection() === 'active') ? 'true' : 'false';

        return $this->parseAttributesForOutput($attributes);
    }

    /**
     * Get the trash section attributes string.
     *
     * @return string
     */
    public function getTrashSectionAttributesString(): string
    {
        $attributes = $this->getTrashSectionAttributes();
        $attributes['href'] = $this->getTrashSectionRoute();
        $attributes['laratables-section'] = 'trash';
        $attributes['laratables-section-active'] = ($this->getCurrentSection() === 'trash') ? 'true' : 'false';

        return $this->parseAttributesForOutput($attributes);
    }

    /**
     * Get the active section attributes.
     *
     * @return array
     */
    public function getActiveSectionAttributes(): array
    {
        $attributes = $this->getElementAttributes('active_section');
        $attributes = $this->getAndMergeElementAttributes('section', $attributes);

        if ($this->getCurrentSection() == 'active') {
            $newAttributes = $this->getElementAttributes('active_section_current');
        } elseif ($this->getCurrentSection() == 'trash') {
            $newAttributes = $this->getElementAttributes('active_section_not_current');
        } else {
            $newAttributes = [];
        }

        return $this->mergeAttributes($attributes, $newAttributes);
    }

    /**
     * Get the trash section attributes.
     *
     * @return array
     */
    public function getTrashSectionAttributes(): array
    {
        $attributes = $this->getElementAttributes('trash_section');
        $attributes = $this->getAndMergeElementAttributes('section', $attributes);

        if ($this->getCurrentSection() == 'trash') {
            $newAttributes = $this->getElementAttributes('trash_section_current');
        } elseif ($this->getCurrentSection() == 'active') {
            $newAttributes = $this->getElementAttributes('trash_section_not_current');
        } else {
            $newAttributes = [];
        }

        return $this->mergeAttributes($attributes, $newAttributes);
    }

    /**
     * Get the current section attributes.
     *
     * @return array
     */
    public function getCurrentSectionAttributes(): array
    {
        $currentSection = $this->getCurrentSection();

        if ($currentSection == 'active') {
            return $this->getElementAttributes('active_section_current');
        }

        if ($currentSection == 'trash') {
            return $this->getElementAttributes('trash_section_current');
        }

        return [];
    }

    /**
     * Get the not current section attributes.
     *
     * @return array
     */
    public function getNotCurrentSectionAttributes(): array
    {
        $currentSection = $this->getCurrentSection();

        if ($currentSection == 'active') {
            return $this->getElementAttributes('trash_section_not_current');
        }

        if ($currentSection == 'trash') {
            return $this->getElementAttributes('active_section_not_current');
        }

        return [];
    }
}
