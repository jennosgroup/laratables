@if ($table->shouldDisplayFooter())
    <tfoot {!! $table->getElementAttributesString('tfoot') !!}>
        <tr {!! $table->getElementAttributesString('tfoot_tr') !!}>
            @foreach ($table->getColumns() as $id => $title)
                <th {!! $table->getThAttributesString($id, $loop->iteration, 'foot') !!}>
                    {!! $table->getThTitle($id, $title, $loop->iteration, 'foot') !!}
                </th>
            @endforeach
        </tr>
    </tfoot>
@endif
