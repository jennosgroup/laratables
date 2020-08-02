<thead {!! $table->getElementAttributesString('thead') !!}>
    <tr {!! $table->getElementAttributesString('thead_tr') !!}>
        @foreach ($table->getColumns() as $id => $title)
            <th {!! $table->getThAttributesString($id, $loop->iteration, 'head') !!}>
                {!! $table->getThTitle($id, $title, $loop->iteration, 'head') !!}
            </th>
        @endforeach
    </tr>
</thead>
