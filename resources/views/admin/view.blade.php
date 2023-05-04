<x-app-layout :title="$user->name">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>
    <button onclick="window.history.back()"
        class="text-white bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded-lg">Back</button>

    <div class="p-4">
        <form action="{{ route('admin.delete', $user->id) }}" method="POST" class="flex justify-end items-center py-2">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 hover:bg-red-700 text-white flex gap-2 font-bold py-2 px-4 rounded mr-2"
                type="submit">
                <p>Delete User</p>
            </button>
        </form>

        <div class="bg-white rounded-lg p-4 mb-4">
            <h2 class="text-xl font-bold mb-4">Profile</h2>

            <div class="md:flex w-full">
                <div class="flex-shrink-0 md:w-1/3 w-full flex flex-col items-center justify-center md:mb-0 mb-4">
                    <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ $user->name }}"
                        class="rounded-full md:w-1/2 w-1/4" />
                    <p class="text-center text-2xl font-bold text-gray-700 dark:text-gray-400 mt-4">{{ $user->name }}
                    </p>
                </div>
                <div class="w-full">
                    <form action="{{ route('admin.update', $user->id) }}" method="POST"
                        class="flex flex-col gap-4 w-full">
                        @csrf
                        @method('POST')
                        <label class="mb-4 flex gap-2 items-center">
                            <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Name:</span>
                            <input type="text" class="outline-none mt-1 block w-full rounded-lg" name="name"
                                value="{{ $user->name }}" />
                        </label>

                        <label class="mb-4 flex gap-2 items-center">
                            <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Role:</span>
                            <select name="role_id" class="outline-none mt-1 block w-full rounded-lg">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        @if ($user->role_id == $role->id) selected @endif>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="mb-4 flex gap-2 items-center">
                            <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Email:</span>
                            <input type="text" class="outline-none mt-1 block w-full rounded-lg" name="email"
                                value="{{ $user->email }}" />
                        </label>

                        <label class="mb-4 flex gap-2 items-center">
                            <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Password:</span>
                            <input type="password" class="outline-none mt-1 block w-full rounded-lg" name="password"
                                placeholder="**************" />
                        </label>

                        <div class="flex justify-end items-center">
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
