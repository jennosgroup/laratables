<form method="get" {!! $table->getElementAttributesString('per_page', [], ['method']) !!}>

    {{-- Add back get parameters except page and per page --}}
    @if ($table->hasQueryParameters())
        @foreach ($table->getQueryParameters($table->getPageKey(), $table->getPerPageKey()) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    @endif

    <select {!! $table->getPerPageSelectAttributesString() !!}>
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
