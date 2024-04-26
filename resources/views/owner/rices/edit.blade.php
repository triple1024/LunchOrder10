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
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    <form method="post"  action="{{ route('owner.rices.update' ,['rice' => $rice->id])}}">
                    @csrf
                    @method('put')
                        <div class="-m-2">
                            <div class="p-2 w-1/4 mx-auto">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">米名 ※必須</label>
                                    <input type="text" id="name" name="name" value="{{ $rice->name }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="p-2 w-1/4 mx-auto">
                                <div class="relative">
                                    <label for="weight" class="leading-7 text-sm text-gray-600">米量(重さ) ※必須</label>
                                    <input type="number" id="weight" name="weight" value="{{ $rice->weight }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="p-2 w-1/4 mx-auto mt-4">
                            <div class="relative flex justify-around">
                                <div>
                                    <input class="mr-2" type="radio" name="is_selling" value="1" @if($rice->is_selling === 1){ checked } @endif >有
                                </div>
                                <div>
                                    <input class="mr-2" type="radio" name="is_selling" value="0" @if($rice->is_selling === 0){ checked } @endif >無
                                </div>
                            </div>
                        </div>

                        <div class="p-2 w-1/3 mx-auto mt-4">
                            <div class="relative justify-around md:flex">
                                <button type="button" onclick="location.href='{{ route('owner.rices.index') }}'" class="flex mx-auto text-black bg-gray-300 border-0 py-2 px-8 mb-2 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-4 mb-2 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                            </div>
                        </div>
                    </form>
                    <form id="delete_{{ $rice->id }}" method="post" action="{{ route('owner.rices.destroy', ['rice' => $rice->id]) }}">
                        @csrf
                        @method('delete')
                        <div class="p-2 w-full flex justify-around mt-4">
                            <a href="#" data-id="{{ $rice->id }}" onclick="deletePost(this)" class="flex justify-center mx-auto text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletePost(e) {
            'use strict';
            if (confirm('本当に削除してもいいですか？')) {
                document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
</x-app-layout>