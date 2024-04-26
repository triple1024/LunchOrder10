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
                    <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                        <div class="flex justify-end mb-4">
                            <button onclick="location.href='{{ route('owner.rices.create')}}'" class="flex  text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録</button>
                        </div>
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">米量(重さ:グラム)</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">有・無</th>
                                    <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                </tr>
                            </thead>
                            @foreach($rices as $rice)
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="{{ route('owner.rices.edit', ['rice' => $rice->id]) }}" class="text-indigo-400 hover:text-indigo-900">
                                                {{ $rice->name}}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">{{ $rice->weight}}</td>
                                        <td class="px-4 py-3">
                                            @if($rice->is_selling)
                                                有
                                            @else
                                                無
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>