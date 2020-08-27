<thead {!! $table->getElementAttributesString('thead') !!}>
    <tr {!! $table->getElementAttributesString('thead_tr') !!}>

        @foreach ($table->getColumns() as $id => $title)
            <th {!! $table->getThAttributesString($id, $loop->iteration, 'head') !!}>

                <div {!! $table->getElementAttributesString('column_title') !!}>
                    <div {!! $table->getElementAttributesString('column_title_content') !!}>
                        {!! $table->getThTitle($id, $title, $loop->iteration, 'head') !!}
                    </div>

                    @if ($table->isColumnSortable($id))
                        <form method="get" {!! $table->getElementAttributesStringWithDefaults('column_title_form', [], ['method']) !!}>

                            {{-- Add back get parameters for the submit except sort and order --}}
                            @if ($table->hasQueryParameters())
                                @foreach ($table->getQueryParameters($table->getPageKey(), $table->getSortKey(), $table->getOrderKey()) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            @endif

                            {{-- Generate the inputs for the sort and order get request --}}
                            {!! $table->generateColumnSortAndOrderInput($id) !!}

                            {{-- Sort Button --}}
                            <button laratables-id="column-sort-button" type="submit" {!! $table->getElementAttributesString('column_sort_button', [], ['type', 'laratables-id']) !!}>
                                @if ($order = $table->getColumnOrderValue($id))
                                    @if ($order == 'desc')
                                        {!! $table->getAscSortIconMarkup() !!}
                                    @else
                                        {!! $table->getDescSortIconMarkup() !!}
                                    @endif
                                @else
                                    {!! $table->getAscSortIconMarkup() !!}
                                @endif
                            </button>
                        </form>
                    @endif
                </div>
            </th>
        @endforeach
    </tr>
</thead>
