<div {!! $table->getElementAttributesString('top_wrapper_middle_left_column') !!}>

    <!-- Bulk Options -->
    @if ($table->shouldDisplayBulkOptions())
        <div {!! $table->getElementAttributesString('bulk_container') !!}>
            @include('laratables::partials.bulk-options')
        </div>
    @endif

    <!-- Page Page -->
    @if ($table->shouldDisplayPerPageOptions())
        <div {!! $table->getElementAttributesString('per_page_container') !!}>
            @include('laratables::partials.per-page')
        </div>
    @endif
</div> <!-- end left column -->

<!-- Right Column -->
<div {!! $table->getElementAttributesString('top_wrapper_middle_right_column') !!}>

    {{-- Active Section --}}
    @if ($table->shouldDisplayActiveSection())
        <a href="{{ $table->getActiveSectionRoute() }}" {!! $table->getAndMergeElementAttributesString('active_section_container', ['class' => ($table->getCurrentSection() == 'active') ? $table->getCurrentSectionClass() : null], ['href', 'laratables-section', 'laratables-section-active']) !!} laratables-section="active" laratables-section-active="{{ ($table->getCurrentSection() === 'active') ? 'true' : 'false' }}">
            @include('laratables::partials.active-section')
        </a>
    @endif

    @if ($table->shouldDisplayTrashSection() && $table->trashIsEnabled())
        <a href="{{ $table->getTrashSectionRoute() }}"  {!! $table->getAndMergeElementAttributesString('trash_section_container', ['class' => ($table->getCurrentSection() == 'trash') ? $table->getCurrentSectionClass() : null], ['href', 'laratables-section', 'laratables-section-active']) !!}laratables-section="trash" laratables-section-active="{{ ($table->getCurrentSection() === 'trash') ? 'true' : 'false' }}">
            @include('laratables::partials.trash-section')
        </a>
    @endif

    {{-- Search --}}
    @if ($table->shouldDisplaySearch())
        <div {!! $table->getElementAttributesString('search_container') !!}>
            @include('laratables::partials.search')
        </div>
    @endif
</div>
