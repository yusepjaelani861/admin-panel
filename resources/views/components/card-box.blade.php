@props(['title', 'icon', 'value'])

<div class="p-6 m-4 bg-blue-500 text-white rounded-lg">
    <div class="flex items-center font-bold">
        {!! $icon !!}
        <div class="mx-5">
            <h4 id="totalFiles" class="text-3xl my-1 text-white">{{ $value }}</h4>
            <div class="text-white text-lg">{{ $title }}</div>
        </div>
    </div>
</div>
