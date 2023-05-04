<?php
function formatPrice($price)
{
    return 'Rp ' . number_format($price, 0, ',', '.');
}
?>
<x-app-layout title="Create Subscription">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Subsscription') }}
        </h2>
    </x-slot>
    <button onclick="window.history.back()"
        class="text-white bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded-lg">Back</button>

    <div class="p-4">
        <div class="bg-white rounded-lg p-4 mb-4">
            <h2 class="text-xl font-bold mb-4">Create Subscription</h2>

            <div class="w-full">
                <form action="{{ route('subscriptions.create') }}" method="POST"
                    class="flex flex-col gap-4 w-full">
                    @csrf
                    @method('POST')
                    <label class="mb-4 flex gap-2 items-center">
                        <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Name:</span>
                        <input type="text" class="outline-none mt-1 block w-full rounded-lg" name="name"
                            placeholder="Name Subscription" />
                    </label>

                    <label class="mb-4 flex gap-2 items-center">
                        <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Price ($):</span>
                        <input type="number" class="outline-none mt-1 block w-full rounded-lg" name="price"
                            placeholder="10" />
                    </label>

                    <label class="mb-4 flex gap-2 items-center">
                        <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[100px]">Max Storage:</span>
                        <input type="number" class="outline-none mt-1 block w-full rounded-lg" name="max_storage"
                            placeholder="512000" />
                        <span class="text-gray-700 dark:text-gray-400 font-bold">MB</span>
                    </label>

                    <div class="flex justify-end items-center">
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
