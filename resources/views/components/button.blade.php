{{-- <button type="{{$type}}" id="{{$id}}" class="btn btn-primary btn-flat" onclick="{{$onclick}}">{{$slot}}</button> --}}
<button {{ $attributes->merge(['class' => 'btn btn-primary btn-flat']) }}>
    {{ $slot }}
</button>

