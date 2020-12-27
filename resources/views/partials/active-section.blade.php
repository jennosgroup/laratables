<a {!! $table->elementHtml('section')
    ->mergeElement('active_section')
    ->mergeElement(
        $table->getCurrentSection() === 'active' ? 'active_section_current' : 'active_section_not_current'
    )->override([
        'href' => $table->getActiveSectionRoute(),
        'laratables-section' => 'active',
        'laratables-section-active' => ($table->getCurrentSection() === 'active') ? 'true' : 'false',
    ])
 !!}>
    {!! $table->getActiveSectionVisualMarkup() !!}
</a>
