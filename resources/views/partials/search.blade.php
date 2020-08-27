<form method="get" {!! $table->getElementAttributesString('search', [], ['method']) !!}>
    {{-- Add get parameters except page & search --}}
    @if ($table->hasQueryParameters())
        @foreach ($table->getQueryParameters($table->getPageKey(), $table->getSearchKey()) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    @endif

    <input {!! $table->getSearchInputAttributesString() !!}>

    <button {!! $table->getSearchButtonAttributesString() !!}>
        {!! $table->getSearchIconMarkup() !!}
    </button>
</form>
