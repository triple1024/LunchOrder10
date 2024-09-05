@php
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

if ($type === 'shops') {
    $folder = 'shops/';
} elseif ($type === 'products') {
    $folder = 'products/';
}

$cloudinaryBaseUrl = 'https://res.cloudinary.com/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload/';

// Cloudinary の URL を組み立てる
$cloudinaryUrl = $cloudinaryBaseUrl . $folder . $filename;

@endphp

<div class="mt-2">
    @if (empty($filename))
        <img src="{{ asset('images/no_images.jpg') }}" alt="No image available">
    @else
        <img src="{{ $cloudinaryUrl }}" alt="{{ $filename }}">
    @endif
</div>
