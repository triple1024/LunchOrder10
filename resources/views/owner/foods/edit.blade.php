<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    <form method="post" action="{{ route('owner.foods.update', ['food' => $food->id])}}">
                    @csrf
                    @method('PUT')
                        <div class="-m-2">
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                                    <input type="text" id="name" name="name" value="{{ $food->name }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                                    <input type="number" id="sort_order" name="sort_order" value="{{ $food->sort_order }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="current_quantity" class="leading-7 text-sm text-gray-600">現在の在庫</label>
                                    <input type="hidden" id="current_quantity" name="current_quantity" value="{{ $quantity }}" >
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded text-base outline-none text-gray-700 py-1 px-3 leading-8">
                                        {{ $quantity }}
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative flex justify-around">
                                    <div>
                                        <input class="mr-2" type="radio" name="type" value="{{ \Constant::FOOD_LIST['add'] }}" checked>追加
                                    </div>
                                    <div>
                                        <input class="mr-2" type="radio" name="type" value="{{ \Constant::FOOD_LIST['reduce'] }}" >削減
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="quantity" class="leading-7 text-sm text-gray-600">数量 ※必須</label>
                                    <input type="number" id="quantity" name="quantity" value="0" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <span class="text-sm">0~99の範囲で入力してください</span>
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー</label>
                                    <select name="category" id="category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        @foreach($categories as $category)
                                            <optgroup label="{{ $category->name }}">
                                            @foreach($category->secondary as $secondary)
                                                <option value="{{ $secondary->id }}" @if( $secondary->id === $food->secondary_category_id) selected @endif>
                                                    {{ $secondary->name}}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto" id="bread-selection" @if($food->secondary_category_id === 3 || $food->secondary_category_id === 4) style="display: none;" @endif>
                                <label for="can_choose_bread" class="leading-7 text-sm text-gray-600">パン選択</label>
                                <div class="relative flex justify-around">
                                    <div>
                                        <input class="mr-2" type="radio" name="can_choose_bread" value="1" @if($food->can_choose_bread){ checked } @endif >パン選択可
                                    </div>
                                    <div>
                                        <input class="mr-2" type="radio" name="can_choose_bread" value="0" @if($food->can_choose_bread === false){ checked } @endif >パン選択不可
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-select-image :images="$images" currentId="{{$food->image1}}" currentImage="{{$food->foodsImage->filename ?? '' }}" name="image1" />
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <div class="relative flex justify-around">
                                <div>
                                    <input class="mr-2" type="radio" name="is_selling" value="1" @if($food->is_selling){ checked } @endif >在庫あり
                                </div>
                                <div>
                                    <input class="mr-2" type="radio" name="is_selling" value="0" @if($food->is_selling === false){ checked } @endif >在庫なし
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full flex justify-around mt-4">
                            <button type="button" onclick="location.href='{{ route('owner.foods.index') }}'" class="flex mx-auto text-black bg-gray-300 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                        </div>
                    </form>
                    <form id="delete_{{ $food->id }}" method="post" action="{{ route('owner.foods.destroy', ['food' => $food->id]) }}">
                        @csrf
                        @method('delete')
                        <div class="p-2 w-full flex justify-around mt-8">
                            <a href="#" data-id="{{ $food->id }}" onclick="deletePost(this)" class="flex justify-center mx-auto text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        'use strict'
        const images = document.querySelectorAll('.image'); // 全ての image タグを取得
        images.forEach(image => {
            image.addEventListener('click', function(e) { // クリックしたら
                const imageName = e.target.dataset.id.substr(0, 6); // data-id の 6 文字
                const imageId = e.target.dataset.id.replace(imageName + '_', ''); // 6 文字カット
                const imageFile = e.target.dataset.file; // ファイル名
                const imagePath = e.target.dataset.path; // 画像のパス（Cloudinary URL プレフィックス）
                const modal = e.target.dataset.modal; // モーダル ID

                // デバッグ: コンソールに値を表示
                console.log('Image Name:', imageName);
                console.log('Image ID:', imageId);
                console.log('Image File:', imageFile);
                console.log('Image Path:', imagePath);
                console.log('Modal:', modal);

                // サムネイルと input type=hidden の value に設定
                document.getElementById(imageName + '_thumbnail').src = imagePath
                document.getElementById(imageName + '_hidden').value = imageId;

                // モーダルを閉じる
                MicroModal.close(modal);
            });
        });

            document.addEventListener("DOMContentLoaded", function() {
            var categorySelect = document.getElementById('category');
            var breadSelection = document.getElementById('bread-selection');

            categorySelect.addEventListener('change', function() {
                var selectedCategory = categorySelect.value;
                if(selectedCategory === '3' || selectedCategory === '4') {
                    breadSelection.style.display = 'none'; // カテゴリーが3または4の場合、パン選択を非表示にする
                } else {
                    breadSelection.style.display = 'block'; // それ以外の場合、パン選択を表示する
                }
            });
        });

        function deletePost(e) {
            'use strict';
            if (confirm('本当に削除してもいいですか？')) {
                document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
</x-app-layout>