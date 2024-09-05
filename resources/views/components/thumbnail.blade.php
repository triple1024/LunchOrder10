@php
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

if ($type === 'shops') {
    $path = 'shops/';
} elseif ($type === 'products') {
    $path = 'products/';
}
@endphp

<div class="mt-2">
    @if (empty($filename))
        <img src="{{ asset('images/no_images.jpg') }}" alt="No image available">
    @else
        @php
            // Cloudinary の画像 URL を生成
            $cloudinaryUrl = Cloudinary::url($filename, [
                'secure' => true,
                'format' => 'auto',
                'quality' => 'auto',
            ]);
        @endphp
        <img src="{{ $cloudinaryUrl }}" alt="{{ $filename }}">
    @endif
</div>
