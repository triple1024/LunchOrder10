<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ホーム') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <!-- <div class="">
                    <img src="{{asset("images/lunch.png")}}" class="w-full h-36 object-cover justify-center">
                </div> -->
                <!-- レトロ -->
                <div class="p-8 bg-yellow-50 text-gray-800 font-serif">
                    <div class="max-w-7xl mx-auto">
                        <div class="text-center pt-6">
                            <h1 class="text-4xl font-bold mb-4 text-brown-900">メニュー</h1>
                        </div>

                        @foreach($primaryCategories as $primaryCategory)
                            <div class="mb-16">
                                <h2 class="text-3xl font-semibold border-b-2 border-gray-300 mb-6 text-brown-800">{{ $primaryCategory->name }}</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                    @foreach($primaryCategory->secondary as $secondaryCategory)
                                        @if($secondaryCategory->foods->isNotEmpty())
                                            <div class="bg-beige p-6 rounded-lg border border-gray-200 shadow-inner">
                                                <h3 class="text-2xl font-bold text-brown-700 bg-yellow-100 p-3 border-t-2 border-b-2 border-yellow-200 mb-4">
                                                    {{ $secondaryCategory->name }}
                                                </h3>
                                                <ul class="space-y-4">
                                                    @foreach($secondaryCategory->foods as $food)
                                                        @php
                                                            $stockQuantity = $food->stock()->sum('quantity');
                                                        @endphp
                                                        @if($stockQuantity > 0)
                                                            <li class="flex justify-between items-center text-lg">
                                                                <a class="text-lg hover:text-red-500" href="{{ route('user.eats.show', ['eat' => $food->id]) }}">
                                                                    {{ $food->name }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
