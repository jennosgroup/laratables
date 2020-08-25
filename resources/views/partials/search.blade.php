<form method="get" {!! $table->getElementAttributesString('search_container_inner', [], ['method']) !!}>

    {{-- Add get parameters except page & search --}}
    @if ($table->hasQueryParameters())
        @foreach ($table->getQueryParameters($table->getPageKey(), $table->getSearchKey()) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    @endif

    <input laratables-id="search-input" type="search" name="{{ $table->getSearchKey() }}" value="{{ $table->getSearchValue() }}" {!! $table->getElementAttributesString('search_input', [], ['type', 'name', 'value', 'laratables-id']) !!}>

    @if (! $table->shouldUseAjax())
        <button laratables-id="search-submit" type="submit" {!! $table->getElementAttributesString('search_submit', [], ['type', 'laratables-id']) !!}>
            {!! $table->getSearchIconMarkup() !!}
        </button>
    @endif
</form>
