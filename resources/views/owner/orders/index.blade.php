<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="flex justify-center mt-4">
            <form method="GET" action="{{ route('owner.orders.index') }}" class="mt-4">
                <div class="flex items-center space-x-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">開始日</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">終了日</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            検索
                        </button>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('owner.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            リセット
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="py-2">
            @if (session('status'))
                <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 mb-4 lg:w-2/3 w-full mx-auto overflow-auto">
                @if ($orders->count() > 0)
                    <table class="table-auto w-full text-left ">
                        <thead>
                            <tr>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm rounded-tl rounded-bl">
                                    <a href="{{ route('owner.orders.index', ['sort' => 'order_date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        注文日
                                        @if (request('sort') === 'order_date')
                                            @if (request('direction') === 'asc')
                                                <span class="text-xs">▲</span>
                                            @else
                                                <span class="text-xs">▼</span>
                                            @endif
                                        @else
                                            <span class="text-xs">▲▼</span> <!-- デフォルトの矢印を表示 -->
                                        @endif
                                    </a>
                                </th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm whitespace-nowrap">ユーザー名</th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm whitespace-nowrap">カテゴリ</th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm whitespace-nowrap">食品名</th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm whitespace-nowrap">数</th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm whitespace-nowrap">ご飯</th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm whitespace-nowrap">注文取り消し</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @foreach ($order->foods as $food)
                                    <tr>
                                        <td class="border px-4 py-2 whitespace-nowrap">{{ $order->order_date->format('Y/m/d H:i') }}</td>
                                        <td class="border px-4 py-2">{{ $order->user->name }}</td>
                                        <td class="border px-4 py-2">{{ optional($food->primaryCategory)->name ?: 'カテゴリなし' }}</td>
                                        <td class="border px-4 py-2 ">{{ $food->name }}</td>
                                        <td class="border px-4 py-2">{{ $food->pivot->quantity }}</td>
                                        <td class="border px-4 py-2 whitespace-nowrap">
                                            @if (in_array($food->secondary_category_id, [3, 4]))
                                                <!-- 空欄にする -->
                                            @else
                                                {{ $order->rice ? $order->rice->name : 'ご飯なし' }}
                                            @endif
                                        </td>
                                        <td class="border px-2 py-2 whitespace-nowrap">
                                            <form method="POST" action="{{ route('owner.orders.cancel', $order->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                    キャンセル
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <p>注文履歴がありません。</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
