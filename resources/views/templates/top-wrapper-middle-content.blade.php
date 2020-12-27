<div {!! $table->elementHtml('top_wrapper_middle_left_column') !!}>

    <!-- Bulk Options -->
    @if ($table->shouldDisplayBulkOptions())
        @include('laratables::partials.bulk-options')
    @endif

    <!-- Page Page -->
    @if ($table->shouldDisplayPerPageOptions())
        @include('laratables::partials.per-page')
    @endif
</div> <!-- end left column -->

<!-- Right Column -->
<div {!! $table->elementHtml('top_wrapper_middle_right_column') !!}>

    {{-- Active Section --}}
    @if ($table->shouldDisplayActiveSection())
        @include('laratables::partials.active-section')
    @endif

    {{-- Trash Section --}}
    @if ($table->shouldDisplayTrashSection() && $table->trashIsEnabled())
        @include('laratables::partials.trash-section')
    @endif

    {{-- Search --}}
    @if ($table->shouldDisplaySearch())
        @include('laratables::partials.search')
    @endif
</div>
