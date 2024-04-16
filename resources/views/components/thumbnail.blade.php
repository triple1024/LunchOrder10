@php

if($type === 'shops'){
    $path = 'storage/shops/';
}
if($type === 'products'){
    $path = 'storage/products/';
}

@endphp


<div class="mt-2">
    @if(empty($filename))
        <img src="{{ asset('images/no_images.jpg') }}">
    @else
        <img src="{{ asset($path . $filename)}}">
    @endif
</div>