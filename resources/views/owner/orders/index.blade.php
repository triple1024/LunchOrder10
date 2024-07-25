<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 mb-4 lg:w-2/3 w-full mx-auto overflow-auto">
                @if ($orders->count() > 0)
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                            <tr>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm rounded-tl rounded-bl">注文日</th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm ">ユーザー名</th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm ">食品名</th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm ">数</th>
                                <th class="border px-4 py-3 title-font tracking-wider font-medium bg-slate-100 text-gray-900 text-sm ">ご飯</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @foreach ($order->foods as $food)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $order->order_date->format('Y-m-d H:i') }}</td>
                                        <td class="border px-4 py-2">{{  $order->user->name }}</td>
                                        <td class="border px-4 py-2">{{ $food->name }}</td>
                                        <td class="border px-4 py-2">{{ $food->pivot->quantity }}</td>
                                        <td class="border px-4 py-2">
                                            @if (in_array($food->secondary_category_id, [3, 4]))
                                                <!-- 空欄にする -->
                                            @else
                                                {{ $order->rice ? $order->rice->name : 'ご飯なし' }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>注文履歴がありません。</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
