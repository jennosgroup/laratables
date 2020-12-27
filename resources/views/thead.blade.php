<thead {!! $table->elementHtml('thead') !!}>
    <tr {!! $table->elementHtml('thead_tr') !!}>

        @foreach ($table->getColumns() as $id => $title)
            <th {!! $table->getThElementHtml($id, $loop->iteration, 'head') !!}>

                <div {!! $table->elementHtml('column_title') !!}>
                    <div {!! $table->elementHtml('column_title_content') !!}>
                        {!! $table->getThTitle($id, $title, $loop->iteration, 'head') !!}
                    </div>

                    @if ($table->isColumnSortable($id))
                        <form method="get" {!! $table->elementHtml('column_title_form')->except(['method']) !!}>

                            {{-- Add back get parameters for the submit except sort and order --}}
                            @if ($queryParameters = $table->getQueryParameters($table->getPageKey(), $table->getSortKey(), $table->getOrderKey()))
                                @foreach ($queryParameters as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            @endif

                            {{-- Generate the inputs for the sort and order get request --}}
                            {!! $table->generateColumnSortAndOrderInput($id) !!}

                            {{-- Sort Button --}}
                            <button laratables-id="column-sort-button" type="submit" {!! $table->elementHtml('column_sort_button')->except(['type', 'laratables-id']) !!}>
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
