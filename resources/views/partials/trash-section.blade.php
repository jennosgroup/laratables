<a {!! $table->elementHtml('section')
    ->mergeElement('trash_section')
    ->mergeElement(
        $table->getCurrentSection() === 'trash' ? 'trash_section_current' : 'trash_section_not_current'
    )->override([
        'href' => $table->getTrashSectionRoute(),
        'laratables-section' => 'trash',
        'laratables-section-active' => ($table->getCurrentSection() === 'trash') ? 'true' : 'false',
    ])
 !!}>
    {!! $table->getActiveSectionVisualMarkup() !!}
</a>
