<form method="get" {!! $table->elementHtml('per_page')->except(['method']) !!}>

    {{-- Add back get parameters except page and per page --}}
    @if ($queryParameters = $table->getQueryParameters($table->getPageKey(), $table->getPerPageKey()))
        @foreach ($queryParameters as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    @endif

    {{-- Select Options --}}
    <select {!! $table->elementHtml('wrapper_selects')->mergeElement('per_page_select')->override(['laratables-id' => 'per-page-select', 'name' => $table->getPerPageKey()]) !!}>
        <option value="">Entries</option>
        @foreach ($table->getPerPageOptions() as $value => $text)
            @if ($table->getPerPageTotal() == $value)
                <option value="{{ $value }}" selected>{{ $text }}</option>
            @else
                <option value="{{ $value }}">{{ $text }}</option>
            @endif
        @endforeach
    </select>
</form>
