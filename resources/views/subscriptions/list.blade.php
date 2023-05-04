<?php
function formatPrice($price)
{
    return 'Rp' . number_format($price, 0, ',', '.');
}

function formatSize($size)
{
    $types = ['B', 'KB', 'MB', 'GB', 'TB'];
    for ($i = 0; $size >= 1024 && $i < count($types) - 1; $size /= 1024, $i++);
    return round($size, 2) . ' ' . $types[$i];
}

?>

<x-app-layout title="Subscription">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Subscription') }}
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="md:flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Subscription</h1>

            <div class="flex md:flex-row flex-col gap-2">
                <a href="{{ route('subscriptions.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <p>Create</p>
                </a>
                <form action="{{ route('subscriptions.index') }}" method="GET"
                    class="flex md:flex-row flex-col w-full gap-2">
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
                            <th class="px-4 py-2">Id</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Max Storage</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            <td class="border px-4 py-2">{{ $role->id }}</td>
                            <td class="border px-4 py-2 font-bold">{{ $role->name }}</td>
                            <td class="border px-4 py-2">${{ $role->price }}</td>
                            <td class="border px-4 py-2">
                                {{ formatSize($role->max_storage * 1024 * 1024) }}
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('subscriptions.view', $role->id) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block">
                                    View
                                </a>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
