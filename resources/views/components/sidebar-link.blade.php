@props([
    'title',
    'route',
    'icon'
])

<li
    class="px-3 py-2 rounded-sm mb-2 last:mb-0 hover:bg-slate-700 {{ request()->routeIs($route) ? 'bg-slate-700' : '' }}">
    <a class="block text-slate-200 hover:text-white truncate transition duration-150"
        :class="page === $title && 'hover:text-slate-200'" href="{{ route($route) }}">
        <div class="flex items-center">
            {!! $icon !!}
            <span class="text-md font-bold text-white dark:text-slate-200 ml-4">{{ $title }}</span>
        </div>
    </a>
</li>
