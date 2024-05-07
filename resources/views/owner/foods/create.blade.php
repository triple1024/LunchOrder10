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
                    <form method="post"  action="{{ route('owner.foods.store')}}">
                    @csrf
                        <div class="-m-2">
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="quantity" class="leading-7 text-sm text-gray-600">初期在庫 ※必須</label>
                                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <span class="text-sm">0~99の範囲で入力してください</span>
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー</label>
                                <select name="category" id="category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    @foreach($categories as $category)
                                            <optgroup label="{{ $category->name }}">
                                            @foreach($category->secondary as $secondary)
                                                <option value="{{ $secondary->id }}" >
                                                    {{ $secondary->name}}
                                                </option>
                                            @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-2 w-1/2 mx-auto" id="bread-selection">
                                <label for="can_choose_bread" class="leading-7 text-sm text-gray-600">パン選択</label>
                                <div class="relative flex justify-around">
                                    <div>
                                        <input class="mr-2" type="radio" name="can_choose_bread" value="1">パン選択可
                                    </div>
                                    <div>
                                        <input class="mr-2" type="radio" name="can_choose_bread" value="0" checked>パン選択不可
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-select-image :images="$images" name="image1" />
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                            <div class="relative flex justify-around">
                                <div>
                                    <input class="mr-2" type="radio" name="is_selling" value="1" checked>在庫あり
                                </div>
                                <div>
                                    <input class="mr-2" type="radio" name="is_selling" value="0" >在庫なし
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full flex justify-around mt-4">
                            <button type="button" onclick="location.href='{{ route('owner.foods.index') }}'" class="flex mx-auto text-black bg-gray-300 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const images = document.querySelectorAll('.image') //全てのimageタグを取得
        images.forEach(image => {
            image.addEventListener('click',function(e){ //クリックしたら
                const imageName = e.target.dataset.id.substr(0,6) //data-idの６文字
                const imageId = e.target.dataset.id.replace(imageName + '_','') //６文字カット
                const imageFile = e.target.dataset.file
                const imagePath = e.target.dataset.path
                const modal = e.target.dataset.modal

                //サムネイルと input type=hiddenのvalueに設定
                document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile
                document.getElementById(imageName + '_hidden').value = imageId
                MicroModal.close(modal); //モーダルを閉じる
            }, )
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
    </script>
</x-app-layout>