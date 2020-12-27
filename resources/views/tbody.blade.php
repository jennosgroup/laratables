<tbody {!! $table->elementHtml('tbody') !!}>
    @if ($table->hasData())
        @foreach ($table->getData() as $item)
            <tr {!! $table->getTbodyTrElementHtml($item, $loop->iteration) !!}>
                @foreach ($table->getColumns() as $id => $title)
                    <td {!! $table->getTbodyTdElementHtml($item, $id, $loop->iteration, $loop->parent->iteration) !!}>
                        {!! $table->getTbodyTdContent($item, $id, $loop->iteration, $loop->parent->iteration) !!}
                    </td>
                @endforeach
            </tr>
        @endforeach
    @else
        <tr {!! $table->elementHtml('tbody_tr_no_items') !!}>
            <td {!! $table->elementHtml('tbody_td_no_items') !!} colspan="{{ $table->getColumnsCount() }}">
                {!! $table->getNoItemsMessage() !!}
            </td>
        </tr>
    @endif
</tbody>
