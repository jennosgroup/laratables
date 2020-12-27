@if ($table->shouldDisplayTfoot())
    <tfoot {!! $table->elementHtml('tfoot') !!}>
        <tr {!! $table->elementHtml('tfoot_tr') !!}>
            @foreach ($table->getColumns() as $id => $title)
                <th {!! $table->getThElementHtml($id, $loop->iteration, 'foot') !!}>
                    {!! $table->getThTitle($id, $title, $loop->iteration, 'foot') !!}
                </th>
            @endforeach
        </tr>
    </tfoot>
@endif
