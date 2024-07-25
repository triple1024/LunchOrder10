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
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                                <ul>
                                    <li>{{ session('error') }}</li>
                                </ul>
                            </div>
                        @endif
                            <h2 class="mt-8 text-xl title-font text-gray-500 tracking-widest">{{ $food->secondaryCategory->name }}</h2>
                            <h1 class="mt-4 text-gray-900 text-3xl title-font font-medium">{{ $food->name }}</h1>
                            @if ($food->secondary_category_id != 13)
                                <h2 class="text-xl mt-8">残り: {{ $quantity }}</h2>
                            @else
                                <h2 class="text-xl mt-8"></h2>
                            @endif
                            <div class="flex justify-between items-center mt-8">
                                <form action="{{ route('user.cart.add') }}" method="post">
                                    @csrf
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <label class="mr-3">数量</label>
                                            <select name="quantity" class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10 mr-8">
                                                @php
                                                    $secondaryCategoryId = $food->secondaryCategory->id;
                                                    $maxQuantity = ($secondaryCategoryId === 1 || $secondaryCategoryId === 2 || $secondaryCategoryId === 13) ? 1 : 2;
                                                @endphp
                                                @for($i = 1; $i <= $maxQuantity; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <label class="mr-3">ご飯</label>
                                            <select name="rice_id" class="rounded border appearance-none border-gray-300 py-2 px-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-4 pr-4">
                                                @if($food->secondary_category_id === 3 || $food->secondary_category_id === 4)
                                                    <option value="4">ご飯なし</option>
                                                @else
                                                    @foreach($rices as $rice)
                                                        <option value="{{ $rice->id }}">{{ $rice->name }} ({{ $rice->weight }}g)</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex mt-12">
                                        <button class="flex text-white bg-indigo-500 border-0 ml-8 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                            カートに入れる
                                        </button>
                                        <input type="hidden" name="food_id" value="{{ $food->id }}">
                                        <button type="button" onclick="location.href='{{ route('user.eats.index') }}'" class="flex mx-auto text-black bg-gray-300 border-0 ml-8 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                    </div>
                                </form>
                            </div>
                            <div class="flex mt-12">
                            @if ($food->can_choose_bread == 1)
                            <p>こちらはパンもおすすめです。</p>
                                <form action="{{ route('user.cart.add') }}" method="post" id="bread-form">
                                    @csrf
                                    <input type="hidden" name="food_id" value="{{ $food->id }}">
                                    <input type="hidden" name="choose_bread" value="1">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="button" onclick="document.getElementById('bread-form').submit()" class="flex mx-auto text-white bg-blue-500 border-0 ml-8 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded text-lg">
                                        パンを選択する
                                    </button>
                                </form>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
