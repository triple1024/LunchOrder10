

<div class="mt-2">

    @if(empty($filename))
        <img src="{{ asset('images/no_images.jpg') }}" alt="No image available">
    @else
        <img src="{{ $filename }}" alt="{{ $filename }}">
    @endif
</div>

