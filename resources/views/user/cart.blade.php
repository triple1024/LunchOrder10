<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カート
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (count($cartFoodsWithRice) > 0)
                        @foreach ($cartFoodsWithRice as $food)
                            <div class="md:flex md:items-center mb-4">
                                <div class="md:w-3/12">
                                    <x-thumbnail filename="{{$food->foodsImage->filename ?? ''}}" type="products" />
                                </div>
                                <div class="md:w-4/12 md:ml-2">
                                    {{ $food->name }}
                                </div>
                                <div class="md:w-4/12 md:ml-2">
                                    @if ($food->rice)
                                        {{ $food->rice->name }}
                                    @else
                                        ご飯なし
                                    @endif
                                </div>
                                <div class="md:w-4/12 md:ml-2">
                                    <label class="mr-3">数量</label>
                                    <select name="quantity" class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10 mr-8">
                                        @php
                                            // 選択されている食品のsecondaryCategoryのIDを取得
                                            $secondaryCategoryId = $food->secondaryCategory->id;
                                            // secondaryCategoryのIDに応じて最大数量を設定
                                            $maxQuantity = ($secondaryCategoryId === 3 || $secondaryCategoryId === 4) ? 2 : 1;
                                        @endphp
                                        @for($i = 1; $i <= $maxQuantity; $i++)
                                            <option value="{{ $i }}" {{ $i == $food->pivot->quantity ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="md:w-2/12">
                                    <form action="{{ route('user.cart.delete', ['eat' => $food->id]) }}" method="post">
                                    @csrf
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-end">
                            <form action="{{ route('user.cart.checkout') }}" method="post">
                                @csrf
                                <button type="submit" class="flex mx-auto text-white bg-green-500 border-0 ml-8 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg">
                                    注文する
                                </button>
                            </form>
                        </div>
                    @else
                        カートの商品を確認して下さい。
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- <script>
        // 各セレクトボックスのクラス名を取得して制御する
        const selects = document.querySelectorAll('select[name="quantity"]');
        let totalQuantity = 0;

        // 初期の合計数量を計算
        selects.forEach(select => {
            totalQuantity += parseInt(select.value);
        });

        // 合計数量が2を超えないように制御
        selects.forEach(select => {
            select.addEventListener('change', function() {
                let currentQuantity = parseInt(select.value);
                let difference = currentQuantity - select.dataset.previousValue;
                totalQuantity += difference;
                select.dataset.previousValue = currentQuantity;

                if (totalQuantity > 2) {
                    alert('合計注文数量は2個以下にしてください。');
                    // 前の値に戻す
                    select.value = select.dataset.previousValue;
                    totalQuantity -= difference;
                }
            });

            // 最初にデータ属性に現在の値をセットする
            select.dataset.previousValue = select.value;
        });
    </script> -->
</x-app-layout>