<?php
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

<x-app-layout title="Users">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="md:flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Users</h1>

            <div class="flex gap-2 flex-shrink-0">
                <form action="{{ route('users.index') }}" method="GET" class="flex md:flex-row flex-col w-full gap-2">
                    <a href="{{ route('users.index', [
                        'expired' => now()->subDays(30)->format('Y-m-d'),
                    ]) }}"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">Expired after
                        29 days</a>
                    <label for="role" class="sr-only">Role</label>
                    <select name="role" id="role"
                        class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block appearance-none leading-normal">
                        <option value="">All</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ request()->role == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                    <label for="search" class="sr-only">Search</label>
                    <input type="text" name="search" id="search" placeholder="Search..."
                        class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal"
                        value="{{ request()->search }}">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block">Search</button>
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
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{ $user->id }}</td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2 font-bold">
                            <?php
                            if (count($user->roles) > 0) {
                                echo $user->roles[0]->name;
                            } else {
                                echo 'Free';
                            }
                            ?>
                        </td>
                        <td
                            class="border px-4 py-2 font-bold {{ $user->role_id === 1 && $user->usage >= 100000000 ? 'text-red-500 font-bold' : '' }}">
                            {{ formatSize($user->usage) }}</td>
                        <td
                            class="border px-4 py-2 font-bold">
                            ${{ $user->balance }}
                            </td>
                        <td class="border px-4 py-2 flex gap-2">
                            <a href="{{ route('users.view', $user->id) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 items-center flex flex-col rounded">View</a>
                        </td>
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

</x-app-layout>
