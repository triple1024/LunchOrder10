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
                <x-flash-message status="session('status')" />
                <div class="flex justify-end mb-4">
                    <button onclick="location.href='{{ route('owner.foods.create')}}'" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録</button>
                </div>
                <div class="flex justify-between mt-6 p-6">
                @foreach ($ownerInfo as $owner)
                    @php
                        // secondary_category_idごとに食品をグループ化
                        $foodsGroupedByCategory = $owner->foods->groupBy('secondary_category_id');
                    @endphp
                    @foreach ($foodsGroupedByCategory as $categoryId => $foods)
                        <div class="mb-6">
                            <h2 class="text-lg font-bold mb-2">{{ $foods->first()->secondaryCategory->name }}</h2>
                            <table class="min-w-full bg-white mb-4">
                                <!-- <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">食品名</th>
                                    </tr>
                                </thead> -->
                                <tbody>
                                    @foreach ($foods as $food)
                                        <tr>
                                            <td class="py-2 px-4 border-b">
                                                <a href="{{ route('owner.foods.edit', ['food' => $food->id]) }}" class="text-indigo-600 hover:text-indigo-900">{{ $food->name }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>