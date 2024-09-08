<div class="w-full max-w-7xl mx-auto p-4" x-data="alpineData">

    @include('livewire.urls.actions')

    <div class="flex justify-between">
        <a href="{{ route('dashboard.links.index') }}" class="mb-2">
            <x-wui-button flat neutral type="button">
                <x-heroicons::mini.solid.arrow-left class="size-4 text-gray-400 dark:text-gray-500"/>
                <span>{{ __('Back to list') }}</span>
            </x-wui-button>
        </a>
    </div>

    <div class="px-4 py-6 md:px-8 md:py-10 bg-white dark:bg-neutral-800 rounded-lg">
        <div class="flex flex-wrap flex-col md:flex-row gap-2 sm:gap-4">
            <h1 class="flex-1 text-gray-900 dark:text-gray-100 text-xl sm:text-2xl xl:text-3xl font-semibold">
                {{ $link->title }}
            </h1>
            <div class="flex flex-wrap justify-end md:justify-normal gap-2 mb-6 lg:mb-0">
                <div>
                    <x-wui-button outline secondary type="button"
                                  @click="copy($el,'{{ route('url.redirect',$link->shortened_url) }}')">
                        <x-heroicons::solid.document-duplicate class="size-4 text-gray-400 dark:text-gray-500"/>
                        <span>{{ __('Copy') }}</span>
                    </x-wui-button>
                </div>
                <div>
                    <x-wui-button outline secondary type="button" wire:click="showShare('{{ $link->shortened_url }}')">
                        <x-heroicons::solid.share class="size-4 text-gray-400 dark:text-gray-500"/>
                        <span>{{ __('Share') }}</span>
                    </x-wui-button>
                </div>
                <a href="{{ route('dashboard.links.edit',$link) }}">
                    <x-wui-button outline secondary type="button">
                        <x-heroicons::solid.pencil class="size-4 text-gray-400 dark:text-gray-500"/>
                        {{ __('Edit') }}
                    </x-wui-button>
                </a>

                <x-wui-dropdown class="absolute inset-0">
                    <x-slot name="trigger">
                        <x-wui-button outline secondary type="button" class="relative">
                            <x-heroicons::solid.ellipsis-horizontal class="size-5 text-gray-400 dark:text-gray-500"/>
                        </x-wui-button>
                    </x-slot>
                    <x-wui-dropdown.item wire:click="deleteModal('{{ $link->shortened_url }}')">
                        <x-heroicons::solid.trash class="size-5 text-red-600 dark:text-red-500"/>
                        <span class="ml-1 text-red-600 dark:text-red-500">{{ __('Delete') }}</span>
                    </x-wui-dropdown.item>
                </x-wui-dropdown>

            </div>
        </div>
        <div class="flex flex-row md:items-center gap-2 sm:gap-4 md:gap-6">
            <div class="size-12 rounded-full bg-gray-100 dark:bg-neutral-900 grid place-items-center">
                <img src="{{ config('app.favicons').$link->url }}" alt=""
                     class="size-8 rounded-full object-cover">
            </div>
            <div class="md:flex-1 flex flex-col gap-y-1">
                <p>
                    <a href="{{ route('url.redirect',$link->shortened_url) }}" target="_blank" rel="nofollow"
                       class="text-base text-blue-600 dark:text-rose-600">
                        {{ str_replace('http://','',str_replace('https://','',route('url.redirect',$link->shortened_url))) }}
                    </a>
                </p>
                <p>
                    <a href="{{ $link->url }}" target="_blank" rel="nofollow"
                       class="text-base text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                        {{ str_replace('http://','',str_replace('https://','',$link->url)) }}
                    </a>
                </p>
            </div>
        </div>
        <hr class="my-6 border-gray-300 dark:border-neutral-700 border-[1px]">
        <div class="flex flex-wrap gap-2">
            <p class="inline-flex items-center gap-2 text-sm">
                <x-heroicons::solid.calendar class="size-5 text-gray-400 dark:text-gray-500"/>
                <span class="text-gray-700 dark:text-gray-300"
                >{{ $link->created_at->isoFormat('LLL') }} {{ config('app.timezone') }}</span>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8 my-10">
        <div
            class="px-4 py-5 inline-flex gap-2 items-center bg-white dark:bg-neutral-800 rounded-lg text-gray-700 dark:text-gray-300">
            <p class="text-base sm:text-lg flex-1 font-medium">
                {{ __(\Illuminate\Support\Str::plural('Engagement', $link->visits)) }}
            </p>
            <p class="text-3xl font-bold px-2">
                {{ $this->parseViewsToSimple($link->visits) }}
            </p>
        </div>

        <div
            class="px-4 py-5 inline-flex gap-2 items-center bg-white dark:bg-neutral-800 rounded-lg text-gray-700 dark:text-gray-300">
            <p class="text-base sm:text-lg flex-1 font-medium">
                {{ __('Last 7 days') }}
            </p>
            <p class="text-3xl font-bold px-2">
                {{ $link->statistics7days->count() }}
            </p>
        </div>

        <div
            class="px-4 py-5 inline-flex gap-2 items-center bg-white dark:bg-neutral-800 rounded-lg text-gray-700 dark:text-gray-300">
            <p class="text-base sm:text-lg flex-1 font-medium">
                {{ __('Weekly change') }}
            </p>
            @if($link->statisticsPrevious7days->count() > 0)
                @php
                    $diff = $link->statistics7days->count() - $link->statisticsPrevious7days->count();
                    $percentage = ($diff / $link->statisticsPrevious7days->count()) * 100;
                    if($percentage > 100){
                        $percentage = 100;
                    }
                @endphp
                @if($percentage > 0)
                    <div class="text-3xl font-bold px-2">
                        <div class="inline-flex items-center gap-2 text-2xl font-bold">
                            <svg class="size-5 text-green-600 dark:text-green-500" xmlns="http://www.w3.org/2000/svg"
                                 height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                                <path
                                    d="m136-240-56-56 296-298 160 160 208-206H640v-80h240v240h-80v-104L536-320 376-480 136-240Z"/>
                            </svg>
                            <span class="text-green-600 dark:text-green-500">+{{ number_format($percentage) }}%</span>
                        </div>
                    </div>
                @elseif($percentage < 0)
                    <div class="text-3xl font-bold px-2">
                        <div class="inline-flex items-center gap-2 text-2xl font-bold">
                            <svg class="size-5 text-red-600 dark:text-red-500"
                                 xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                 fill="currentColor">
                                <path
                                    d="M640-240v-80h104L536-526 376-366 80-664l56-56 240 240 160-160 264 264v-104h80v240H640Z"/>
                            </svg>
                            <span class="text-red-600 dark:text-red-500">{{ number_format($percentage) }}%</span>
                        </div>
                    </div>
                @else
                    <div class="text-3xl font-bold px-2">
                        <span class="text-gray-500 dark:text-gray-400">{{ number_format($percentage) }}%</span>
                    </div>
                @endif
            @else
                @if($link->statistics7days->count() > 0)
                    <div class="text-3xl font-bold px-2">
                        <div class="inline-flex items-center gap-2 text-2xl font-bold">
                            <svg class="size-5 text-green-600 dark:text-green-500" xmlns="http://www.w3.org/2000/svg"
                                 height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                                <path
                                    d="m136-240-56-56 296-298 160 160 208-206H640v-80h240v240h-80v-104L536-320 376-480 136-240Z"/>
                            </svg>
                            <span class="text-green-600 dark:text-green-500">+100%</span>
                        </div>
                    </div>
                @else
                    <div class="text-3xl font-bold px-2">
                        <span class="text-gray-500 dark:text-gray-400">0%</span>
                    </div>
                @endif
            @endif
        </div>
    </div>


    <div class="grid grid-cols-1 gap-4 sm:gap-6 md:gap-8 my-10">
        <div
            class="px-4 py-5 md:p-8 w-full bg-white dark:bg-neutral-800 rounded-lg text-gray-700 dark:text-gray-300">
            <h3 class="text-base sm:text-lg md:text-xl flex-1 font-medium">
                {{ __('QR Code') }}
            </h3>
            <div class="my-4">
                <div class="flex gap-4">
                    <div class="rounded-xl border overflow-hidden size-36 bg-white">
                        <div id="qr" class="size-36 text-gray-800 dark:text-gray-200 grid place-items-center"></div>
                        <div id="download_qr" class="hidden"></div>
                    </div>

                    <div class="flex flex-col">
                        <div class="flex flex-wrap gap-2">

                            <x-wui-button outline secondary type="button"
                                          @click="copy($el,'{{ route('url.redirect',$link->shortened_url) }}')">
                                <x-heroicons::solid.chart-bar class="size-4 text-gray-400 dark:text-gray-500"/>
                                <span>{{ __('View details') }}</span>
                            </x-wui-button>

                            <x-wui-dropdown class="absolute inset-0">
                                <x-slot name="trigger">
                                    <x-wui-button outline secondary type="button" class="relative">
                                        <x-heroicons::solid.ellipsis-horizontal
                                            class="size-5 text-gray-400 dark:text-gray-500"/>
                                    </x-wui-button>
                                </x-slot>
                                <x-wui-dropdown.item wire:click="deleteModal('{{ $link->shortened_url }}')">
                                    <svg class="size-5 text-gray-700 dark:text-gray-300"
                                         xmlns="http://www.w3.org/2000/svg"
                                         height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                                        <path
                                            d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 32.5-156t88-127Q256-817 330-848.5T488-880q80 0 151 27.5t124.5 76q53.5 48.5 85 115T880-518q0 115-70 176.5T640-280h-74q-9 0-12.5 5t-3.5 11q0 12 15 34.5t15 51.5q0 50-27.5 74T480-80Zm0-400Zm-220 40q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm120-160q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm200 0q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm120 160q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17ZM480-160q9 0 14.5-5t5.5-13q0-14-15-33t-15-57q0-42 29-67t71-25h70q66 0 113-38.5T800-518q0-121-92.5-201.5T488-800q-136 0-232 93t-96 227q0 133 93.5 226.5T480-160Z"/>
                                    </svg>

                                    <span class="ml-1 text-gray-700 dark:text-gray-300">{{ __('Customize') }}</span>
                                </x-wui-dropdown.item>
                                <x-wui-dropdown.item @click="downloadQr('png')">
                                    <x-heroicons::solid.arrow-down-tray
                                        class="size-5 text-gray-700 dark:text-gray-300"/>
                                    <span class="ml-1 text-gray-700 dark:text-gray-300">{{ __('Download PNG') }}</span>
                                </x-wui-dropdown.item>
                                <x-wui-dropdown.item @click="downloadQr('jpg')">
                                    <x-heroicons::solid.arrow-down-tray
                                        class="size-5 text-gray-700 dark:text-gray-300"/>
                                    <span class="ml-1 text-gray-700 dark:text-gray-300">{{ __('Download JPG') }}</span>
                                </x-wui-dropdown.item>
                                <x-wui-dropdown.item @click="downloadQr('svg')">
                                    <x-heroicons::solid.arrow-down-tray
                                        class="size-5 text-gray-700 dark:text-gray-300"/>
                                    <span class="ml-1 text-gray-700 dark:text-gray-300">{{ __('Download SVG') }}</span>
                                </x-wui-dropdown.item>
                            </x-wui-dropdown>
                        </div>
                        <div class="mt-4">
                            <span class="font-bold">{{ $this->parseViewsToSimple($link->visits_qr) }}</span>
                            Total scans
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:gap-6 md:gap-8 my-10">
        <div
            class="px-4 py-5 md:p-8 w-full bg-white dark:bg-neutral-800 rounded-lg text-gray-700 dark:text-gray-300">
            <h3 class="text-base sm:text-lg md:text-xl flex-1 font-medium">
                {{ __('Locations') }}
            </h3>
            <div class="my-4">
                @if(count($link->statistics7days->sortBy('country')->groupBy('country')) > 0)
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-neutral-700">
                        <thead>
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-base font-semibold text-gray-600 dark:text-gray-400 sm:pl-0">
                                {{ __('Country') }}
                            </th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-base font-semibold text-gray-600 dark:text-gray-400"></th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-base font-semibold text-gray-600 dark:text-gray-400">
                                {{ __('Engagements') }}
                            </th>
                            <th scope="col"
                                class="relative py-3.5 pl-3 pr-4 sm:pr-0 text-right text-gray-600 dark:text-gray-400 text-base">
                                %
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-800">
                        @foreach($link->statistics7days->sortBy('country')->groupBy('country') as $country => $statistics)
                            <tr>
                                <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-0">
                                    {{ blank($country) ? __('Unknown') : $country }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-900 dark:text-gray-100 w-full">
                                    <div class="overflow-hidden rounded-full bg-gray-200 w-11/12 md:max-w-xl mx-auto">
                                        <div class="h-2 rounded-full bg-rose-600"
                                             style="width: {{ ($statistics->count() / $link->statistics7days->count()) * 100 }}%"></div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $statistics->count() }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 pl-3 pr-4 text-right sm:pr-0 text-sm text-gray-900 dark:text-gray-100">
                                    {{ number_format(($statistics->count() / $link->statistics7days->count()) * 100, 1) }}
                                    %
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="-mt-4 text-4xl text-gray-500 text-center grid place-items-center size-full">
                        No data to show
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 md:gap-8 my-10">
        <div
            class="px-4 py-5 md:p-8 w-full bg-white dark:bg-neutral-800 rounded-lg text-gray-700 dark:text-gray-300">
            <h3 class="text-base sm:text-lg md:text-xl flex-1 font-medium">
                {{ __('Referrers') }}
            </h3>
            <div class="my-4 size-full">
                @if($referrerData->isEmpty())
                    <div class="-mt-8 text-4xl text-gray-500 text-center grid place-items-center size-full">
                    No data to show
                    </div>
                @endif
                <canvas id="refererChart" class="max-w-xs w-full mx-auto h-full mb-12"></canvas>
                @foreach($link->statistics7days->groupBy('referer') as $referrer => $statistics)
                    <div class="flex flex-col">
                        <div class="flex items center gap-2">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    @if(!blank($referrer))
                                        {{ $this->getHostFormReferer($referrer) }}
                                    @else
                                        {{ __('Direct') }}
                                    @endif
                                </p>
                            </div>
                            <div class="flex-1">
                                <div class="overflow-hidden rounded-full bg-gray-200 w-11/12 md:max-w-xl mx-auto">
                                    <div class="h-2 rounded-full bg-rose-600"
                                         style="width: {{ ($statistics->count() / $link->statistics7days->count()) * 100 }}%"></div>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $statistics->count() }}
                                </p>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-right text-gray-900 dark:text-gray-100">
                                    {{ number_format(($statistics->count() / $link->statistics7days->count()) * 100, 1) }}
                                    %
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <div
            class="px-4 py-5 md:p-8 w-full bg-white dark:bg-neutral-800 rounded-lg text-gray-700 dark:text-gray-300">
            <h3 class="text-base sm:text-lg md:text-xl flex-1 font-medium">
                {{ __('Devices') }}
            </h3>
            <div class="my-4 size-full">
                <div class="-mt-8 text-4xl text-gray-500 text-center grid place-items-center size-full">
                    Coming soon
                </div>
            </div>
        </div>

    </div>


@vite(['resources/js/qr.js','resources/js/charts.js'])
<script>
    function alpineData() {
        return {
            copy(el, value) {
                el.innerText = '{{ __('Copied') }}';
                setTimeout(() => {
                    el.innerText = '{{ __('Copy') }}';
                }, 2000);
                navigator.clipboard.writeText(value);
            },
            init() {
                makeQr('{{ route('qr.redirect',$link->shortened_url) }}');
                donutRefererChart(@json($referrerData->pluck('host')),@json($referrerData->pluck('count')));
            },
            downloadQr(mime = 'svg') {
                download_qr.download({
                    name: '{{ $link->shortened_url }}',
                    extension: mime
                })
            }
        }
    }
</script>

</div>
