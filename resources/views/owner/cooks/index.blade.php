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
                        <!-- ご飯の炊き上げ量の指示メッセージを表示 -->
                    <div class="mb-8 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 text-center rounded">
                        @if($riceCups > 0)
                            <h2 class="text-6xl font-bold">今日は{{ $riceCups }}合炊いて下さい。</h2>
                        @else
                            <h2 class="text-6xl font-bold">本日はご飯の注文がありません。</h2>
                        @endif
                    </div>
                    @if(count($riceOrders) > 0)
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">ユーザー</th>
                                    <th class="py-2 px-4 border-b">ご飯の量</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riceOrders as $order)
                                    @if($order->rice->id !== 4) <!-- rice_idが4の場合はスキップ -->
                                        <tr>
                                            <td class="py-2 px-4 border-b text-center">{{ $order->user->name ?? 'Unknown' }}</td>
                                            <td class="py-2 px-4 border-b text-center">{{ $order->rice->name ?? 'Unknown' }} : {{ $order->rice->weight ?? 'Unknown' }}g</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>本日はご飯の注文がありません。</p>
                    @endif

                    <button onclick="location.href='{{ route('owner.orders.index')}}'" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">注文履歴(一覧)に戻る</button>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>