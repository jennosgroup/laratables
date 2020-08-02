<tbody {!! $table->getElementAttributesString('tbody') !!}>
    @if ($table->hasData())
        @foreach ($table->getData() as $item)
            <tr {!! $table->getTbodyTrAttributesString($item, $loop->iteration) !!}>
                @foreach ($table->getColumns() as $id => $title)
                    <td {!! $table->getTbodyTdAttributesString($item, $id, $loop->iteration, $loop->parent->iteration) !!}>
                        {!! $table->getTdContent($item, $id, $loop->iteration, $loop->parent->iteration) !!}
                    </td>
                @endforeach
            </tr>
        @endforeach
    @else
        <tr {!! $table->getElementAttributesString('tbody_tr_no_items') !!}>
            <td {!! $table->getElementAttributesString('tbody_td_no_items') !!} colspan="{{ $table->getColumnsCount() }}">
                {!! $table->getNoItemsMessage() !!}
            </td>
        </tr>
    @endif
</tbody>
