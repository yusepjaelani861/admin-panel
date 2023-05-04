@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if ($title)
        <title>{{ $title }} - {{ config('app.name', 'Laravel') }}</title>
    @else
        <title>{{ config('app.name', 'Laravel') }}</title>
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="/assets/js/jquery.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div id="modalbree"></div>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="fixed z-20 w-full px-4 py-2 dark:bg-slate-900 bg-slate-800 border-b border-gray-500 shadow-md">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button class="text-white" onclick="toggleSidebar()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <a href="{{ route('dashboard') }}">
                        <h1 class="text-2xl font-bold text-gray-100 text-center px-4">{{ config('app.name') }}</h1>
                    </a>
                </div>
                <div class="flex items-center hover:bg-gray-700 p-2 rounded-lg">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D8ABC&color=fff&size=128"
                        alt="Logo" class="w-8 h-8 rounded-full">
                    <span class="text-md font-bold text-gray-100 ml-2">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
        <div id="navLogout" class="fixed z-10 top-16 right-2 w-40 p-2 dark:bg-slate-900 bg-slate-800 rounded-lg"
            style="display: none;">
            <button
                class="text-sm w-full font-bold px-2 py-1 text-gray-100 hover:bg-gray-600 rounded-lg">Logout</button>
        </div>
        @include('layouts.sidebar')
        <div class="flex h-full md:ml-64 pt-16">

            <!-- Page Content -->
            <main class="min-h-screen w-full dark:bg-gray-300 bg-gray-100">
                <div class="p-4">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @if (session('error'))
        <x-modal name="error-message" :show="true">
            <div class="bg-white p-4 rounded-lg text-red-500 font-medium text-center">
                <h1 class="text-2xl font-bold text-black underline px-4">Notification</h1>
                <p>{{ session('error') }}</p>
            </div>
        </x-modal>
    @endif

    @if (session('success'))
        <x-modal name="error-message" :show="true">
            <div class="bg-white p-4 rounded-lg text-green-500 font-medium text-center">
                <h1 class="text-2xl font-bold text-black underline px-4">Notification</h1>
                <p>{{ session('success') }}</p>
            </div>
        </x-modal>
    @endif

    <script>
        const navlogout = $('#navLogout');
        $('.flex.items-center.hover\\:bg-gray-700.p-2.rounded-lg').on('click', function() {
            navlogout.toggle();
        });
        $('.text-sm.w-full.font-bold.px-2.py-1.text-gray-100.hover\\:bg-gray-600.rounded-lg').on('click', function() {
            navlogout.hide();
        });
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.flex.items-center.hover\\:bg-gray-700.p-2.rounded-lg').length) {
                navlogout.hide();
            }
        });
        $('.text-sm.w-full.font-bold.px-2.py-1.text-gray-100.hover\\:bg-gray-600.rounded-lg').on('click', function() {
            $.ajax({
                url: '/logout',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    window.location.href = '/';
                }
            });
        });
    </script>

    <script src="/assets/js/helper.js"></script>
    <script>
        const sidebar = document.getElementById("sidebar-toggle");
    </script>
</body>

</html>
