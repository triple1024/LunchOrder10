@php
    if( $name === 'image1'){ $modal = 'modal-1'; }
    if( $name === 'image2'){ $modal = 'modal-2'; }
    $cImage = $currentImage ?? '' ;
    $cId = $currentId ?? '' ;
@endphp

<div class="modal micromodal-slide" id="{{ $modal }}" aria-hidden="true">
    <div class="modal__overlay z-50" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="{{ $modal }}-title">
            <header class="modal__header">
                <h2 class="text-xl text-gray-700" id="{{ $modal }}-title">
                    ファイルを選択して下さい
                </h2>
                <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="{{ $modal }}-content">
                <div class="flex flex-wrap">
                    @foreach ( $images as $image )
                    <div class="w-1/4 p-2 md:p-4">
                        <div class="border rounded-md p-2 md:p-4">
                            <img class="image" data-id="{{ $name }}_{{ $image->id }}"
                                data-file="{{ $image->filename }}"
                                data-path="{{ $image->filename }}"
                                data-modal="{{ $modal }}"
                                src="{{ $image->filename }}"> <!-- 修正ポイント -->
                            <div class="text-gray-700 text-center mt-2">
                                {{ $image->title }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </main>
            <footer class="modal__footer">
                <button type="button" class="modal__btn" data-micromodal-close aria-label="閉じる">閉じる</button>
            </footer>
        </div>
    </div>
</div>

<div class="flex justify-around items-center mb-4">
    <a class="py-2 px-4 bg-gray-200" data-micromodal-trigger="{{ $modal }}" href='javascript:;'>ファイルを選択</a>
    <div class="w-1/4">
        <img id="{{ $name }}_thumbnail" @if($cImage) src="{{ $cImage }}" @else src="" @endif> <!-- 修正ポイント -->
    </div>
</div>
<input id="{{ $name }}_hidden" type="hidden" name="{{ $name }}" value="{{ $cId }}">
