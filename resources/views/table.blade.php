{{-- Table Wrapper --}}
<div {!! $table->getElementAttributesString('wrapper') !!} {!! $table->getWrapperAdditionalAttributesString() !!}>

    {{-- Top Table First Extra Content --}}
    @if ($table->shouldDisplayTopWrapperTopContent() && $table->hasTopWrapperTopContent())
        <div {!! $table->getElementAttributesString('top_wrapper_top') !!}>
            {!! $table->getTopWrapperTopContent() !!}
        </div>
    @endif

    {{-- Top Table Second Extra Content --}}
    @if ($table->shouldDisplayTopWrapperMiddleContent() && $table->hasTopWrapperMiddleContent())
        <div {!! $table->getElementAttributesString('top_wrapper_middle') !!}>
            {!! $table->getTopWrapperMiddleContent() !!}
        </div>
    @endif

    {{-- Top Table Third Extra Content --}}
    @if ($table->shouldDisplayTopWrapperBottomContent() && $table->hasTopWrapperBottomContent())
        <div {!! $table->getElementAttributesString('top_wrapper_bottom') !!}>
            {!! $table->getTopWrapperBottomContent() !!}
        </div>
    @endif

    {{-- Table Container --}}
    <div {!! $table->getElementAttributesString('container') !!}>

        {{-- Start Table --}}
        <table {!! $table->getElementAttributesString('table') !!}>
            @include('laratables::thead')
            @include('laratables::tbody')
            @include('laratables::tfoot')
        </table> <!-- end table -->
    </div> <!-- end container -->

    {{-- Bottom Table First Extra Content --}}
    @if ($table->shouldDisplayBottomWrapperTopContent() && $table->hasBottomWrapperTopContent())
        <div {!! $table->getElementAttributesString('bottom_wrapper_top') !!}>
            {!! $table->getBottomWrapperTopContent() !!}
        </div>
    @endif

    {{-- Bottom Table Second Extra Content --}}
    @if ($table->shouldDisplayBottomWrapperMiddleContent() && $table->hasBottomWrapperMiddleContent())
        <div {!! $table->getElementAttributesString('bottom_wrapper_middle') !!}>
            {!! $table->getBottomWrapperMiddleContent() !!}
        </div>
    @endif

    {{-- Bottom Table Third Extra Content --}}
    @if ($table->shouldDisplayBottomWrapperBottomContent() && $table->hasBottomWrapperBottomContent())
        <div {!! $table->getElementAttributesString('bottom_wrapper_bottom') !!}>
            {!! $table->getBottomWrapperBottomContent() !!}
        </div>
    @endif

</div> <!-- end wrapper -->
