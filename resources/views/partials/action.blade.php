<{{ ($table->getActionDisplayType() == 'button') ? 'button' : 'a' }} {!! $table->elementHtml('actions_'.$table->getActionDisplayType())
    ->mergeElement($action.'_action_'.$table->getActionDisplayType())
    ->override([
        'onclick' => ($table->getActionDisplayType() == 'button') ? 'event.preventDefault(); this.querySelector("form").submit();' : null,
        ($table->getActionDisplayType() == 'button') ? 'type' : 'href' => ($table->getActionDisplayType() == 'button') ? 'submit' : $route,
    ])
!!}>

    @if ($table->getActionContentType() == 'icon')
        {!! $table->getActionIconMarkup($action) !!}
    @elseif ($table->getActionContentType() == 'text')
        {{ $table->getActionText($action) }}
    @endif

    {{-- Add the form so we can submit values with the request --}}
    @if ($queryParameters = $table->getActionQueryParameters($action))
        <form style="display: none;" method="{{ ($method == 'get') ? 'get' : 'post' }}" action="{{ $route }}">

            {{-- CSRF Token --}}
            @if ($method != 'get')
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @endif

            {{-- Method Spoofing --}}
            @if (! in_array($method, ['get', 'post']))
                <input type="hidden" name="_method" value="{{ strtoupper($method) }}">
            @endif

            {{-- Add query args that the user requested --}}
            @foreach ($queryParameters as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>
    @endif
</{{ ($table->getActionDisplayType() == 'button') ? 'button' : 'a' }}>
