<{{ ($table->getActionDisplayType() == 'button') ? 'button' : 'a' }} {!! $table->getActionElementAttributesString($action, $route, $method) !!}>

    @if ($table->getActionContentType() == 'icon')
        {!! $table->getActionIconMarkup($action) !!}
    @elseif ($table->getActionContentType() == 'text')
        {{ $table->getActionText($action) }}
    @endif

    {{-- Add the form so we can submit values with the request --}}
    @if (! empty($table->getActionQueryParameters($action)) || $method != 'get')
        <form style="display: none;" method="{{ (in_array($method, ['get', 'post'])) ? $method : 'post' }}" action="{{ $route }}">

            {{-- CSRF Token --}}
            @if ($method != 'get')
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @endif

            {{-- Method Spoofing --}}
            @if (! in_array($method, ['get', 'post']))
                <input type="hidden" name="_method" value="{{ strtoupper($method) }}">
            @endif

            {{-- Add query args that the user requested --}}
            @foreach ($table->getActionQueryParameters($action) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>
    @endif
</{{ ($table->getActionDisplayType() == 'button') ? 'button' : 'a' }}>
