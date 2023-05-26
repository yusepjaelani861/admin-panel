<x-app-layout title="Configuration">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configuration') }}
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="bg-white rounded-lg p-4 mb-4">
            <h2 class="text-xl font-bold mb-4">Configuration Server</h2>

            <div class="w-full">
                <form action="{{ route('configuration.update') }}" method="POST" class="flex flex-col gap-4 w-full">
                    @csrf
                    @method('POST')
                    <label class="mb-4 flex gap-2 items-center">
                        <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[150px]">Domain Upload:</span>
                        <input type="text" class="outline-none mt-1 block w-full rounded-lg" name="upload_domain"
                            placeholder="https://upload.domain.com" />
                    </label>

                    <label class="mb-4 flex gap-2 items-start">
                        <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[150px]">Ads Header:</span>
                        <textarea name="ads_header" cols="30" rows="10"
                            class="outline-none mt-1 block w-full rounded-lg" placeholder="<div>Paste di sini bang</div>">{!! $ads_header !!}</textarea>
                    </label>

                    <label class="mb-4 flex gap-2 items-start">
                        <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[150px]">Ads Body:</span>
                        <textarea name="ads_body" id="ads_body" cols="30" rows="10"
                            class="outline-none mt-1 block w-full rounded-lg" placeholder="<div>Paste di sini bang</div>">{!! $ads_body !!}</textarea>
                    </label>

                    <label class="mb-4 flex gap-2 items-start">
                        <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[150px]">Ads Footer:</span>
                        <textarea name="ads_footer" cols="30" rows="10"
                            class="outline-none mt-1 block w-full rounded-lg" placeholder="<div>Paste di sini bang</div>">{!! $ads_footer !!}</textarea>
                    </label>

                    <label class="mb-4 flex gap-2 items-start">
                        <span class="text-gray-700 dark:text-gray-400 flex-shrink-0 w-[150px]">Script Ads:</span>
                        <textarea name="ads_script" id="ads_script" cols="30" rows="10"
                            class="outline-none mt-1 block w-full rounded-lg" placeholder="<script>Paste di sini bang</script>">{!! $ads_script !!}</textarea>
                    </label>

                    <div class="flex justify-end items-center">
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
