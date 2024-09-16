<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="w-full  mx-auto sm:px-6 lg:px-8">
            <div class="flex space-x-4">
                <div class="bg-white shadow-md rounded-lg mb-2 w-1/3 overflow-auto">
                    <h2 class="text-lg font-bold bg-inherit px-4 py-2">本日の注文</h2>
                    <div class="max-h-96 overflow-y-auto p-6">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">ユーザー名</th>
                                    <th class="py-2 px-4 border-b">食品名</th>
                                    <th class="py-2 px-4 border-b">注文数</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayOrders as $order)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $order['user_name'] }}</td>
                                        <td class="py-2 px-4 border-b">{{ $order['food_name'] }}</td>
                                        <td class="py-2 px-4 border-b text-center">{{ $order['quantity'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button onclick="location.href='{{ route('owner.orders.index')}}'" class="mt-8 bg-blue-500 text-white py-2 px-4 rounded">注文履歴(一覧)に戻る</button>
                    </div>
                </div>
                @foreach ($stocksByCategory as $category => $stocks)
                    @php
                        // カテゴリに応じた背景色を設定
                        switch ($category) {
                            case '弁当': // カテゴリ1に対する背景色
                                $bgColor = 'bg-orange-500';
                                break;
                            case 'パン': // カテゴリ2に対する背景色
                                $bgColor = 'bg-cyan-300';
                                break;
                            default: // デフォルトの背景色
                                $bgColor = 'bg-gray-500';
                        }
                    @endphp
                    <div class="bg-white shadow-md rounded-lg mb-2 w-1/3 mx-auto overflow-auto">
                        <h2 class="text-lg font-bold {{ $bgColor }} px-4 py-2">{{ $category }}の在庫</h2>
                        <div class="max-h-96 overflow-y-auto p-6">
                            <table class="min-w-full bg-white mb-4 table-fixed">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b w-2/3">食品名</th> <!-- 幅を2/3に設定 -->
                                        <th class="py-2 px-4 border-b w-1/3 text-center">数量</th> <!-- 幅を1/3に設定 -->
                                    </tr>
                                </thead>
                                <tbody class="sortable-list">
                                    @foreach ($stocks as $stock)
                                        <tr data-id="{{ $stock->food_id }}">
                                            <td class="py-2 px-4 border-b">
                                                <a href="{{ url('/owner/foods/' . $stock->food_id . '/edit') }}" class="hover:underline">
                                                    {{ $foodNames[$stock->food_id] }} <!-- ここで食品名を取得 -->
                                                </a>
                                            </td>
                                            <td class="py-2 px-4 border-b text-center">{{ $stock->total_quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // 各 tbody に対して Sortable を初期化
        document.querySelectorAll('tbody.sortable-list').forEach(function (tbody) {
            const sortable = new Sortable(tbody, {
                animation: 150,
                draggable: 'tr',
                onStart: function(evt) {
                    evt.item.setAttribute('draggable', true);
                },
                onEnd: function (evt) {
                    let stocks = [];
                    tbody.querySelectorAll('tr').forEach((row, index) => {
                        const id = row.dataset.id;
                        if (id) {
                            stocks.push({
                                id: id,
                                position: index + 1
                            });
                        } else {
                            console.error('Missing id for row:', row);
                        }
                    });

                    console.log('Sending stocks:', stocks);

                    fetch('/owner/stocks/reorder', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            stocks: stocks
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { throw new Error(text); });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response:', data);
                        if (data.message === 'Order updated successfully') {
                            // 成功した場合の処理
                            // alert('順序が更新されました。');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('エラーが発生しました: ' + error.message);
                    });
                }
            });
        });
    });
</script>




</x-app-layout>