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

<x-app-layout :title="$user->name">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>
    <button onclick="window.history.back()"
        class="text-white bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded-lg">Back</button>

    <div class="p-4">
        <div class="flex md:flex-row flex-col gap-2 justify-end">
            <form action="{{ route('files.backup') }}" method="POST" class="flex justify-end items-center">
                @csrf
                @method('POST')
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <button class="bg-blue-500 hover:bg-blue-700 text-white flex gap-2 font-bold py-2 px-4 rounded mr-2"
                    type="submit">
                    <p>Backup Storage</p>
                </button>
            </form>

            <form action="{{ route('files.empty.user') }}" method="POST" class="flex justify-end items-center">
                @csrf
                @method('POST')
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <button class="bg-red-500 hover:bg-red-700 text-white flex gap-2 font-bold py-2 px-4 rounded mr-2"
                    type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    <p>Empty Storage</p>
                </button>
            </form>
        </div>

        <div class="md:grid md:grid-cols-3 grid-cols-2 w-full">
            <x-card-box title="Total Files"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="shrink-0 w-12 h-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
              </svg>'
                value="{{ $user->files->count() }}" />
            <x-card-box title="Total Folders"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="shrink-0 w-12 h-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
              </svg>'
                value="{{ $user->folders->count() }}" />
            <x-card-box title="Usage"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="shrink-0 w-12 h-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
              </svg>'
                value="{{ formatSize($user->files->sum('size')) }}" />
        </div>

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
                    <form action="{{ route('users.update', $user->id) }}" method="POST"
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
                            <div class="flex gap-2">
                                <p class="py-1 px-2 rounded-lg bg-orange-500 font-bold">{{ $user->role->name }}</p>
                                <button type="button" class="py-1 px-2 rounded-lg text-blue-500 hover:text-blue-600"
                                    onclick="modalHandler('open')">Change</button>
                            </div>
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

        <div class="bg-white rounded-lg p-4 mb-4">
            <h2 class="text-xl font-bold mb-4">History Transactions</h2>

            <div class="w-full overflow-auto">
                <table class="table-auto w-full text-center">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Fee</th>
                            <th class="px-4 py-2">Method</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $key => $transaction)
                            <td class="border px-4 py-2">{{ $transaction->merchant_ref }}</td>
                            <td class="border px-4 py-2">{{ convertDate($transaction->created_at) }}</td>
                            <td class="border px-4 py-2">
                                {{ formatPrice($transaction->amount - json_decode($transaction->data)->total_fee) }}
                            </td>
                            <td class="border px-4 py-2">{{ formatPrice(json_decode($transaction->data)->total_fee) }}
                            </td>
                            <td class="border px-4 py-2">{{ json_decode($transaction->data)->payment_name }}</td>
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

                @if (count($transactions) > 0)
                    <div class="p-4 flex justify-center items-center">
                        <a href="{{ route('transactions.index', [
                            'user' => $user->name,
                        ]) }}"
                            class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">View All</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg p-4 mb-4">
            <h2 class="text-xl font-bold mb-4">List Files</h2>

            <div class="w-full overflow-auto">
                <table class="table-auto w-full text-center">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">id</th>
                            <th class="px-4 py-2">Folder</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Size</th>
                            <th class="px-4 py-2">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $key => $file)
                            <tr>
                                <td class="border px-4 py-2">{{ $file->id }}</td>
                                <td class="border px-4 py-2">{{ $file->folders ? $file->folders->name : 'None' }}</td>
                                <td class="border px-4 py-2 flex flex-col items-center justify-center">
                                    <img src="{{ $file->original_url }}" alt="{{ $file->name }}"
                                        class="w-20 h-20 object-cover" />
                                    <p>{{ $file->name }}</p>
                                </td>
                                <td class="border px-4 py-2">{{ formatSize($file->size) }}</td>
                                <td class="border px-4 py-2">{{ convertDate($file->created_at) }}</td>
                            </tr>
                        @endforeach
                        @if (count($files) == 0)
                            <tr>
                                <td colspan="5" class="border px-4 py-2">No data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if (count($files) > 0)
                    <div class="p-4 flex justify-center items-center">
                        <a href="{{ route('files.index', [
                            'user' => $user->name,
                        ]) }}"
                            class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">View All</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-700 bg-opacity-50 transition duration-150 ease-in-out z-50 fixed top-0 right-0 bottom-0 left-0"
        id="modal">
        <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-lg">
            <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
                <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">Change Role</h1>
                <form action="{{ route('users.roles', $user->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <label for="name" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Select
                        Role</label>
                    <select name="role_id" id="role"
                        class="w-full border border-gray-400 rounded px-3 py-2 mt-1 mb-5 text-gray-700 focus:outline-none focus:border-blue-700">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" <?php echo $user->role_id == $role->id ? 'selected' : ''; ?>>{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <div class="flex items-center justify-start w-full">
                        <button type="submit"
                            class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out hover:bg-blue-600 bg-blue-500 rounded text-white px-8 py-2 text-sm">Submit</button>
                        <button
                            class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm"
                            type="button" onclick="modalHandler()">Cancel</button>
                    </div>
                    <button
                        class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600"
                        onclick="modalHandler()" aria-label="close modal" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20"
                            height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        let modal = document.getElementById("modal");
        fadeOut(modal);

        function modalHandler(val) {
            if (val) {
                fadeIn(modal);
            } else {
                fadeOut(modal);
            }
        }

        function fadeOut(el) {
            el.style.opacity = 1;
            (function fade() {
                if ((el.style.opacity -= 0.1) < 0) {
                    el.style.display = "none";
                } else {
                    requestAnimationFrame(fade);
                }
            })();
        }

        function fadeIn(el, display) {
            el.style.opacity = 0;
            el.style.display = display || "flex";
            (function fade() {
                let val = parseFloat(el.style.opacity);
                if (!((val += 0.2) > 1)) {
                    el.style.opacity = val;
                    requestAnimationFrame(fade);
                }
            })();
        }
    </script>
</x-app-layout>
