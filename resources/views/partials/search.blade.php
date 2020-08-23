<form method="get">

    {{-- Add get parameters except page & search --}}
    @if ($table->hasQueryParameters())
        @foreach ($table->getQueryParameters($table->getPageKey(), $table->getSearchKey()) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    @endif

    <input {!! $table->getElementAttributesString('search_input') !!} type="search" name="{{ $table->getSearchKey() }}" value="{{ $table->getSearchValue() }}">
</form>
