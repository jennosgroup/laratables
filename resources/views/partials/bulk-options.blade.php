<form>
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

    <select name="{{ $table->getBulkActionKey() }}" laratables-id="bulk-options-select" {!! $table->getElementAttributesString('bulk_options_select', [], ['name', 'laratables-id']) !!}>
        <option value="">Select Bulk Option</option>
        @foreach ($table->getBulkOptions() as $option)
            <option {!! $table->getAndMergeElementAttributesString('', $option, ['title']) !!}>
                {{ $option['title'] }}
            </option>
        @endforeach
    </select>
</form>
