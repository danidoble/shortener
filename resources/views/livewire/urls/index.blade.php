<div class="p-4 w-full mx-auto max-w-7xl" x-data="alpineData">
    <div class="flex justify-between">
        <h1 class="flex-1 text-2xl sm:text-3xl font-bold text-black dark:text-white">Links</h1>
        <a href="{{ route('dashboard.links.create') }}">
            <x-button type="button">Create link</x-button>
        </a>
    </div>

    @include('livewire.urls.actions')

    <div class="flex flex-col gap-4 my-6 w-full">
        @foreach($links as $link)
            <div class="px-4 py-6 bg-white dark:bg-neutral-800 rounded-lg">
                <div class="flex flex-col md:flex-row md:items-center gap-2 sm:gap-4 md:gap-6">
                    <div class="size-12 rounded-full bg-gray-100 dark:bg-neutral-900 grid place-items-center">
                        <img src="{{ config('app.favicons').$link->url }}" alt=""
                             class="size-8 rounded-full object-cover">
                    </div>
                    <div class="md:flex-1 flex flex-col gap-y-1">
                        <h3 class="text-gray-900 dark:text-gray-100 text-lg font-semibold">
                            {{ $link->title }}
                        </h3>
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
                        <div class="flex flex-wrap gap-2">
                            @if($link->visits > 0)
                                <p class="inline-flex items-center gap-2 text-sm">
                                    <x-heroicons::outline.chart-bar class="size-5 text-green-600 dark:text-green-500"/>
                                    <span
                                        class="text-green-600 dark:text-green-500">{{ $link->visits }} {{ __(\Illuminate\Support\Str::plural('Engagement', $link->visits)) }}</span>
                                </p>
                            @endif
                            <p class="inline-flex items-center gap-2 text-sm">
                                <x-heroicons::solid.calendar class="size-5 text-gray-400 dark:text-gray-500"/>
                                <span class="text-gray-700 dark:text-gray-300"
                                >{{ $link->created_at->isoFormat('ll') }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-end md:justify-normal gap-2">
                        <x-wui-button outline secondary type="button"
                                      @click="copy($el,'{{ route('url.redirect',$link->shortened_url) }}')">
                            <x-heroicons::solid.document-duplicate class="size-4 text-gray-400 dark:text-gray-500"/>
                            <span>{{ __('Copy') }}</span>
                        </x-wui-button>
                        <x-wui-button outline secondary type="button" wire:click="showShare('{{ $link->shortened_url }}')">
                            <x-heroicons::solid.share class="size-4 text-gray-400 dark:text-gray-500"/>
                            <span>{{ __('Share') }}</span>
                        </x-wui-button>
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
                            <x-wui-dropdown.item wire:click="details('{{ $link->shortened_url }}')">
                                <x-heroicons::solid.link class="size-5 text-gray-400 dark:text-gray-500"/>
                                <span class="ml-1">{{ __('View link details') }}</span>
                            </x-wui-dropdown.item>
                            <x-wui-dropdown.item>
                                <x-heroicons::solid.qr-code class="size-5 text-gray-400 dark:text-gray-500"/>
                                <span class="ml-1">{{ __('View QR Code') }}</span>
                            </x-wui-dropdown.item>
                        </x-wui-dropdown>

                    </div>
                </div>
            </div>
        @endforeach

        <div class="flex justify-center w-full">
            {{ $links->links() }}
        </div>
    </div>
</div>

<script>
    function alpineData() {
        return {
            copy(el, value) {
                el.innerText = '{{ __('Copied') }}';
                setTimeout(() => {
                    el.innerText = '{{ __('Copy') }}';
                }, 2000);
                navigator.clipboard.writeText(value);
            }
        }
    }
</script>
