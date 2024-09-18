<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-flash-message status="session('status')" />
                    <div class="flex justify-end mb-4">
                        <button onclick="location.href='{{ route('owner.foods.create')}}'" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録</button>
                    </div>
                    @php
                        // 全食品をsecondaryCategoryのIDでグループ化
                        $foodsGroupedByCategory = $foods->groupBy('secondaryCategory.id');

                        // カテゴリー名を取得するためのカテゴリーデータ
                        $categories = \App\Models\SecondaryCategory::all()->keyBy('id');
                    @endphp
                    <div class="flex justify-between mt-6 p-2">
                        @foreach ($foodsGroupedByCategory as $categoryId => $foodsByCategory)
                            @php
                                $categoryName = $categories->get($categoryId)->name ?? '未分類';
                            @endphp
                            <div class="w-full mb-6 p-4">
                                <h2 class="text-lg font-bold mb-6">{{ $categoryName }}</h2>
                                <table class="min-w-full bg-white mb-4">
                                    <tbody>
                                        @foreach ($foodsByCategory as $food)
                                            <tr>
                                                <td class="py-2 border-b">
                                                    <a href="{{ route('owner.foods.edit', ['food' => $food->id]) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        {{ $food->name }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>