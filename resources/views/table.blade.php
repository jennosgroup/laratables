{{-- Table Wrapper --}}
<div {!! $table->elementHtml('wrapper')->override(['laratables-wrapper' => 'yes', 'laratables-id' => $table->getId(), 'laratables-checkbox-name' => $table->getCheckboxName()]) !!}>

    {{-- Top Table First Extra Content --}}
    @if ($table->shouldDisplayTopWrapperTopContentView() && $table->hasTopWrapperTopContentView())
        <div {!! $table->elementHtml('top_wrapper_top') !!}>
            @include($table->getTopWrapperTopContentView())
        </div>
    @endif

    {{-- Top Table Second Extra Content --}}
    @if ($table->shouldDisplayTopWrapperMiddleContentView() && $table->hasTopWrapperMiddleContentView())
        <div {!! $table->elementHtml('top_wrapper_middle') !!}>
            @include($table->getTopWrapperMiddleContentView())
        </div>
    @endif

    {{-- Top Table Third Extra Content --}}
    @if ($table->shouldDisplayTopWrapperBottomContentView() && $table->hasTopWrapperBottomContentView())
        <div {!! $table->elementHtml('top_wrapper_bottom') !!}>
            @include($table->getTopWrapperBottomContentView())
        </div>
    @endif

    {{-- Table Container --}}
    <div {!! $table->elementHtml('container') !!}>
        <table {!! $table->elementHtml('table') !!}>
            @include('laratables::thead')
            @include('laratables::tbody')
            @include('laratables::tfoot')
        </table> <!-- end table -->
    </div> <!-- end container -->

    {{-- Bottom Table First Extra Content --}}
    @if ($table->shouldDisplayBottomWrapperTopContentView() && $table->hasBottomWrapperTopContentView())
        <div {!! $table->elementHtml('bottom_wrapper_top') !!}>
            @include($table->getBottomWrapperTopContentView())
        </div>
    @endif

    {{-- Bottom Table Second Extra Content --}}
    @if ($table->shouldDisplayBottomWrapperMiddleContentView() && $table->hasBottomWrapperMiddleContentView())
        <div {!! $table->elementHtml('bottom_wrapper_middle') !!}>
            @include($table->getBottomWrapperMiddleContentView())
        </div>
    @endif

    {{-- Bottom Table Third Extra Content --}}
    @if ($table->shouldDisplayBottomWrapperBottomContentView() && $table->hasBottomWrapperBottomContentView())
        <div {!! $table->elementHtml('bottom_wrapper_bottom') !!}>
            @include($table->getBottomWrapperBottomContentView())
        </div>
    @endif
</div> <!-- end wrapper -->
