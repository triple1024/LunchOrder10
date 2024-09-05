@php
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

if($type === 'shops'){
    $path = '';  // Cloudinary では `storage/shops/` を使用しない
}
if($type === 'products'){
    $path = '';  // Cloudinary では `storage/products/` を使用しない
}
@endphp

<div class="mt-2">
    @if(empty($filename))
        <img src="{{ asset('images/no_images.jpg') }}" alt="No image available">
    @else
        <img src="{{ Cloudinary::getUrl($filename) }}">
    @endif
</div>
