<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="md:flex md:justify-around">
                        <div class="md:w-1/2">
                            <x-thumbnail filename="{{$food->foodsImage->filename ?? ''}}" type="products" />
                        </div>
                        <div class="md:w-1/2 ml-12">
                            <h2 class="mt-8 text-xl title-font text-gray-500 tracking-widest">{{ $food->secondaryCategory->name }}</h2>
                            <h1 class="mt-4 text-gray-900 text-3xl title-font font-medium">{{ $food->name }}</h1>
                            <h2 class="text-xl mt-8">残り: {{ $quantity }}</h2>
                            <div class="flex justify-between items-center mt-8">
                                <form action="{{ route('user.cart.add') }}" method="post">
                                @csrf
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <label class="mr-3">数量</label>
                                            <select name="quantity" class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10 mr-8">
                                            @php
                                                // secondaryCategoryのIDを取得
                                                $secondaryCategoryId = $food->secondaryCategory->id;

                                                // secondaryCategoryが「弁当」の場合
                                                if ($secondaryCategoryId === 1 || $secondaryCategoryId === 2) { // 弁当のIDが1または2
                                                    $maxQuantity = 1;
                                                } else {
                                                    // secondaryCategoryが「パン」の場合
                                                    $maxQuantity = 2;
                                                }
                                            @endphp
                                            @for($i = 1; $i <= $maxQuantity; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                            </select>
                                            <label class="mr-3">ご飯</label>

                                            <select name="rice_id" class="rounded border appearance-none border-gray-300 py-2 px-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-4 pr-4" @if($food->secondary_category_id !== 1 && $food->secondary_category_id !== 2) disabled @endif>
                                                @if($food->secondary_category_id !== 1 && $food->secondary_category_id !== 2)
                                                    <option value="" selected disabled hidden>選択できません</option>
                                                @else
                                                    @foreach($rices as $rice)
                                                        <option value="{{ $rice->id }}">{{ $rice->name }} ({{ $rice->weight }}g)</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex mt-12">
                                        <button class="flex  text-white bg-indigo-500 border-0 ml-8 py-2 px-6  focus:outline-none hover:bg-indigo-600 rounded">
                                                カートに入れる
                                        </button>
                                        <input type="hidden" name="food_id" value="{{ $food->id }}">
                                        <button type="button" onclick="location.href='{{ route('user.eats.index') }}'" class="flex mx-auto text-black bg-gray-300 border-0 ml-8 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
