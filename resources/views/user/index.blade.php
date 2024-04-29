<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ホーム') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @foreach($primaryCategories as $primaryCategory)
                    <div class="flex flex-wrap w-full my-10 flex-col items-center text-center">
                        <h2 class="text-6xl">{{ $primaryCategory->name }}</h2>
                    </div>
                    <div class="flex flex-wrap">
                        @foreach($primaryCategory->secondaryCategories as $secondaryCategory)
                            @if($secondaryCategory->foods->isNotEmpty())
                                <div class="w-1/2 p-2 md:p-4">
                                    <div class="text-gray-700 text-center mt-2">
                                        <h3 class="text-4xl">{{ $secondaryCategory->name }}</h3>
                                        <ul class="my-10 text-xl">
                                            @foreach($secondaryCategory->foods as $food)
                                                <li>{{ $food->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
                <h3 class="text-5xl">ご飯のみ</h3>
                <div class="flex gap-4">
                    @foreach($rices as $rice)
                    <div class="bg-gray-200 p-4 mt-10">
                        <ul class="my-4 text-3xl">
                            <li>{{ $rice->name }}</li>
                            <li>{{ $rice->weight }}グラム</li>
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
