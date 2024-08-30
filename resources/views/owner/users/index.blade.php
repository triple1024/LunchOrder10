<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            利用者一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-4">
                <div class="md:p-6 text-gray-900">
                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 mx-auto">
                            <x-flash-message status="session('status')" />
                            <div class="flex justify-end mb-4">
                                <button onclick="location.href='{{ route('owner.users.create')}}'" class="flex  text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録</button>
                            </div>
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-center whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">作成日</th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $user)
                                        <tr >
                                            <td class="border-t-2 border-gray-200 md:px-4 py-3 text-center">{{ $user->name }}</td>
                                            <td class="border-t-2 border-gray-200 md:px-4 py-3 text-center">{{ $user->email }}</td>
                                            <td class="border-t-2 border-gray-200 md:px-4 py-3 text-center">{{ $user->created_at->diffForHumans() }}</td>
                                            <td class="border-t-2 border-gray-200 md:px-4 py-3">
                                                <button type="button" onclick="location.href='{{ route('owner.users.edit',['user' => $user->id]) }}'" class="flex mx-auto text-white bg-indigo-400 border-0 py-2 px-7 focus:outline-none hover:bg-indigo-500 rounded">編集する</button>
                                            </td>
                                            <form id="delete_{{ $user->id }}" method="post" action="{{ route('owner.users.destroy', ['user' => $user->id]) }}">
                                                @csrf
                                                @method('delete')
                                                <td class="border-t-2 border-gray-200 md:px-4 py-3">
                                                    <a href="#" data-id="{{ $user->id }}" onclick="deletePost(this)" class="flex justify-center mx-auto text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </section>

                    {{-- エロクアント
                        @foreach ($e_all as $e_owner)
                            {{ $e_owner->name }}
                            {{ $e_owner->created_at->diffForHumans() }}
                        @endforeach
                    <br>
                    クエリビルダ
                    @foreach ($q_get as $q_owner)
                        {{ $q_owner->name }}
                        {{ Carbon\Carbon::parse($q_owner->created_at)->diffForHumans() }}
                    @endforeach --}}
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