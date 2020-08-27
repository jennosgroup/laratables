<form {!! $table->getElementAttributesString('bulk', [], ['method']) !!}>
    <input type="hidden" laratables-id="bulk-options-csrf-token" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" laratables-id="bulk-options-method" name="_method" value="">

    <input type="hidden" name="{{ $table->getPageKey() }}" value="{{ $table->getPageNumber() }}">
    <input type="hidden" name="{{ $table->getPerPageKey() }}" value="{{ $table->getPerPageTotal() }}">

    {{-- Add back get parameters except page and per page --}}
    @if ($table->hasQueryParameters())
        @foreach ($table->getQueryParameters($table->getPageKey(), $table->getPerPageKey()) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    @endif

    <select {!! $table->getBulkSelectAttributesString() !!}>
        <option value="">Select Bulk Option</option>
        @foreach ($table->getBulkOptions() as $option)
            <option {!! $table->getAndMergeElementAttributesString('', $option) !!}>
                {{ $option['title'] }}
            </option>
        @endforeach
    </select>
</form>
