@php
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

if ($type === 'shops') {
    $folder = 'shops/';
} elseif ($type === 'products') {
    $folder = 'products/';
}

// Cloudinary の URL を生成するための基本の URL プレフィックス
$cloudinaryUrl = 'https://res.cloudinary.com/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload/' . $folder . $filename;
@endphp

<div class="mt-2">
    @if (empty($filename))
        <img src="{{ asset('images/no_images.jpg') }}" alt="No image available">
    @else
        <img src="{{ $cloudinaryUrl }}" alt="{{ $filename }}">
    @endif
</div>
