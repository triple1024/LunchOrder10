@php

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

if($type === 'shops'){
    $path = 'storage/shops/';
}
if($type === 'products'){
    $path = 'storage/products/';
}

@endphp


<div class="mt-2">
    @if(empty($filename))
        <img src="{{ asset('images/no_images.jpg') }}" alt="No image available">
    @else
        <img src="{{ Cloudinary::image($path . $filename)->encode() }}" alt="{{ $filename }}">
    @endif
</div>