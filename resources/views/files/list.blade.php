<?php
function formatSize($size)
{
    $types = ['B', 'KB', 'MB', 'GB', 'TB'];
    for ($i = 0; $size >= 1024 && $i < count($types) - 1; $size /= 1024, $i++);
    return round($size, 2) . ' ' . $types[$i];
}

function convertDate($date)
{
    $date = strtotime($date);
    return date('l, d F Y', $date);
}

?>

<x-app-layout title="Files">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Files') }}
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="md:flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Users</h1>

            <div class="flex gap-2">
                <form action="{{ route('files.index') }}" method="GET" class="flex md:flex-row flex-col w-full gap-2">
                    <label for="search-user" class="sr-only">Search User</label>
                    <input type="text" name="user" id="search-user" placeholder="Search User..."
                        class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal"
                        value="{{ request()->user }}">
                    <label for="search" class="sr-only">Search</label>
                    <input type="text" name="search" id="search" placeholder="Search..."
                        class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal"
                        value="{{ request()->search }}">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block">Search</button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4">
            <div class="w-full overflow-auto">
                <table class="table-auto w-full text-center">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">id</th>
                            <th class="px-4 py-2">Username</th>
                            <th class="px-4 py-2">Folder</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Size</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $key => $file)
                            <tr>
                                <td class="border px-4 py-2">{{ $file->id }}</td>
                                <td class="border px-4 py-2">{{ $file->user->name }}</td>
                                <td class="border px-4 py-2">{{ $file->folders ? $file->folders->name : 'None' }}
                                </td>
                                <td class="border px-4 py-2 flex flex-col items-center justify-center">
                                    {{-- <img src="{{ $file->original_url }}" alt="{{ $file->name }}"
                                        class="w-20 h-20 object-cover" /> --}}
                                    <p>{{ $file->name }}</p>
                                </td>
                                <td class="border px-4 py-2">{{ formatSize($file->size) }}</td>
                                <td class="border px-4 py-2">{{ convertDate($file->created_at) }}</td>
                                <td class="px-4 py-2 flex gap-2 items-center">
                                    <a href="{{ $file->original_url }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        target="_blank">View</a>
                                    <form action="{{ route('files.delete', $file->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if (count($files) == 0)
                            <tr>
                                <td colspan="6" class="border px-4 py-2">No data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $files->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        let ids = [];

        function select(event) {
            // if (event.checked == true) {
            //     ids.push(event.value);
            // } else {
            //     ids = ids.filter((item) => {
            //         return item != event.value;
            //     })
            // }
            // console.log(ids);
            console.log('hahaah')
        }

        function selectAll() {
            let checkbox = document.getElementById('select-all');
            let selectOne = document.querySelectorAll('#select-one');
            if (checkbox.checked == true) {
                selectOne.forEach((item) => {
                    ids.push(item.value);
                    item.checked = true;
                })
            } else {
                selectOne.forEach((item) => {
                    item.checked = false;
                    ids = [];
                })
            }

            console.log(ids)
        }
    </script>
</x-app-layout>
