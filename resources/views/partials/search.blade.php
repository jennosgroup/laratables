<form method="get" {!! $table->elementHtml('search')->except(['method']) !!}>
    {{-- Add get parameters except page & search --}}
    @if ($table->hasQueryParameters())
        @foreach ($table->getQueryParameters($table->getPageKey(), $table->getSearchKey()) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    @endif

    {{-- Search Input Field --}}
    <input {!! $table->elementHtml('search_input')->override(['laratables-id' => 'search-input', 'type' => 'search', 'name' => $table->getSearchKey(), 'value' => $table->getSearchValue()]) !!}>

    {{-- Search Button --}}
    <button {!! $table->elementHtml('search_submit')->override(['laratables-id' => 'search-submit', 'type' => 'submit']) !!}>
        {!! $table->getSearchIconMarkup() !!}
    </button>
</form>
