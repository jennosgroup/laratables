<thead {!! $table->getElementAttributesString('thead') !!}>
    <tr {!! $table->getElementAttributesString('thead_tr') !!}>

        @foreach ($table->getColumns() as $id => $title)
            <th {!! $table->getThAttributesString($id, $loop->iteration, 'head') !!}>

                <div class="laratables-title-column-container">
                    <div class="laratables-title-column-content">
                        {!! $table->getThTitle($id, $title, $loop->iteration, 'head') !!}
                    </div>

                    @if ($table->isColumnSortable($id))
                        <div class="laratables-title-column-icon">
                            <form class="laratables-title-column-sort-icon-form" method="get">

                                {{-- Add back get parameters for the submit except sort and order --}}
                                @if ($table->hasQueryParameters())
                                    @foreach ($table->getQueryParameters($table->getPageKey(), $table->getSortKey(), $table->getOrderKey()) as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach
                                @endif

                                {{-- Generate the inputs for the sort and order get request --}}
                                {!! $table->generateColumnSortAndOrderInput($id) !!}

                                {{-- Sort Button --}}
                                <button laratables-id="column-sort-button" type="submit" {!! $table->getElementAttributesString('sort_button', [], ['type', 'laratables-id']) !!}>
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
                        </div>
                    @endif
                </div>
            </th>
        @endforeach
    </tr>
</thead>
