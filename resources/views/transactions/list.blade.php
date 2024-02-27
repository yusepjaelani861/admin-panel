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

function formatPrice($price)
{
    return 'Rp' . number_format($price, 0, ',', '.');
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
                <form action="{{ route('transactions.index') }}" method="GET" class="flex md:flex-row flex-col w-full gap-2">
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
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Username</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Amount</th>
                            {{-- <th class="px-4 py-2">Fee</th> --}}
                            {{-- <th class="px-4 py-2">Method</th> --}}
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $key => $transaction)
                            <td class="border px-4 py-2">{{ $transaction->reference }}</td>
                            <td class="border px-4 py-2">{{ $transaction->user->name }}</td>
                            <td class="border px-4 py-2">{{ convertDate($transaction->created_at) }}</td>
                            <td class="border px-4 py-2">{{ formatPrice($transaction->amount) }}</td>
                            {{-- <td class="border px-4 py-2">
                                {{ formatPrice($transaction->amount - json_decode($transaction->data)->total_fee) }}
                            </td>
                            <td class="border px-4 py-2">{{ formatPrice(json_decode($transaction->data)->total_fee) }}
                            </td> --}}
                            {{-- <td class="border px-4 py-2">{{ json_decode($transaction->data)->payment_name }}</td> --}}
                            <td class="border px-4 py-2 font-bold <?php
                            switch ($transaction->status) {
                                case 'UNPAID':
                                    echo 'text-yellow-500';
                                    break;
                                case 'PAID':
                                    echo 'text-green-500';
                                    break;
                                case 'FAILED':
                                    echo 'text-red-500';
                                    break;
                                default:
                                    echo 'text-gray-500';
                                    break;
                            }
                            ?>">{{ $transaction->status }}</td>
                            </tr>
                        @endforeach

                        @if (count($transactions) == 0)
                            <tr>
                                <td colspan="6" class="border px-4 py-2">No data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="mt-4">
                    {!! $transactions->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
