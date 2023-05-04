<?php
function formatPrice($price)
{
    return 'Rp ' . number_format($price, 0, ',', '.');
}

function convertDate($date)
{
    $date = strtotime($date);
    return date('l, d F Y', $date);
}

function formatSize($size)
{
    $types = ['B', 'KB', 'MB', 'GB', 'TB'];
    for ($i = 0; $size >= 1024 && $i < count($types) - 1; $size /= 1024, $i++);
    return round($size, 2) . ' ' . $types[$i];
}
?>
<x-app-layout :title="$role->name">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $role->name }}
        </h2>
    </x-slot>
    <button onclick="window.history.back()"
        class="text-white bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded-lg">Back</button>

    <div class="p-4">
        <form action="{{ route('subscriptions.delete', $role->id)}}" method="POST" class="flex justify-end items-center">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 hover:bg-red-700 text-white flex gap-2 font-bold py-2 px-4 rounded mr-2"
                onclick="#" {{ $role->id === 1 ? 'disabled' : '' }}>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                <p>Delete</p>
            </button>
        </form>

        <div class="md:grid md:grid-cols-3 grid-cols-2 w-full">
            <x-card-box title="Total Subcribed"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="shrink-0 w-12 h-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
              </svg>'
                value="{{ $total_subscribed }}" />
            <x-card-box title="Total Earning"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="shrink-0 w-12 h-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
              </svg>'
                value="{{ formatPrice($total_earning) }}" />
            <x-card-box title="User Active"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="shrink-0 w-12 h-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
              </svg>'
                value="{{ $user_active }}" />
        </div>

        <div class="bg-white rounded-lg p-4 mb-4">
            <h2 class="text-xl font-bold mb-4">Role {{ $role->name }}</h2>

            <div class="md:flex w-full">
                <div class="flex-shrink-0 md:w-1/3 w-full flex flex-col items-center justify-center md:mb-0 mb-4">
                    <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ $role->name }}"
                        class="rounded-full md:w-1/2 w-1/4" />
                    <p class="text-center text-2xl font-bold text-gray-700 dark:text-gray-400 mt-4">{{ $role->name }}
                    </p>
                </div>
                <div class="w-full">
                    <form action="{{ route('subscriptions.update', $role->id) }}" method="POST"
                        class="flex flex-col gap-4 w-full">
                        @csrf
                        @method('POST')
                        <label class="mb-4 flex gap-2 items-center">
                            <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Name:</span>
                            <input type="text" class="outline-none mt-1 block w-full rounded-lg" name="name"
                                value="{{ $role->name }}" />
                        </label>

                        <label class="mb-4 flex gap-2 items-center">
                            <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Price ($):</span>
                            <input type="number" class="outline-none mt-1 block w-full rounded-lg" name="price"
                                value="{{ $role->price }}" />
                        </label>

                        <label class="mb-4 flex gap-2 items-center">
                            <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Max Storage:</span>
                            <input type="number" class="outline-none mt-1 block w-full rounded-lg" name="max_storage"
                                value="{{ $role->max_storage }}" />
                            <span class="text-gray-700 dark:text-gray-400 font-bold">MB</span>
                        </label>

                        <div class="flex justify-end items-center">
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white rounded-lg overflow-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Usage</th>
                        <th class="px-4 py-2">Expired At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="text-center">
                            <td class="border px-4 py-2">{{ $user->id }}</td>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2 font-bold">{{ $user->role->name }}</td>
                            <td
                                class="border px-4 py-2 font-bold {{ $user->role_id === 1 && $user->usage >= 100000000 ? 'text-red-500 font-bold' : '' }}">
                                {{ formatSize($user->usage) }}</td>
                            <td
                                class="border px-4 py-2 font-bold {{ $user->log && $user->log->end_date < now() ? 'text-red-500' : '' }} {{ $user->log && $user->log->role_id !== $user->role_id ? 'text-yellow-500' : '' }} {{ $user->role_id === 1 ? 'text-green-500' : '' }}">
                                {{ $user->log ? convertDate($user->log->end_date) : 'Lifetime' }}</td>
                        </tr>
                    @endforeach

                    @if ($users->count() === 0)
                        <tr>
                            <td colspan="5" class="text-center">No users found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->links() }}
            </div>

            <div class="flex justify-end p-2 w-full items-center gap-4">
                <div class="flex gap-2 items-center text-xs">
                    <div class="bg-green-500 w-2 h-2"></div>
                    <p>Lifetime</p>

                    <div class="bg-yellow-500 w-2 h-2"></div>
                    <p>Role Changed / Not Sync</p>

                    <div class="bg-red-500 w-2 h-2"></div>
                    <p>Expired / Usage Exceed</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
