<div class="w-full max-w-4xl mx-auto sm:px-6 lg:px-8" x-data="alpineData">

    <div class="flex justify-between mt-6">
        <h1 class="flex-1 text-2xl sm:text-3xl font-bold text-black dark:text-white">Edit link</h1>

        @if(route('dashboard.links.index') === url()->previous() || route('dashboard.links.edit', $db_url) === url()->previous())
            <a href="{{ route('dashboard.links.index') }}">
                <x-button type="button">Back</x-button>
            </a>
        @else
            <a href="{{ url()->previous() }}">
                <x-button type="button">Back</x-button>
            </a>
        @endif

    </div>

    @if($success)
        <x-modal name="persistentModal" wire:model="success">
            <div class="p-4 bg-white dark:bg-gray-900">
                <div class="rounded-md bg-green-50 dark:bg-transparent p-4">
                    <div class="inline-flex w-full gap-2">
                        <h3 class="text-xl font-medium text-black dark:text-white flex-1">
                            {{ __('Updated successfully') }}
                        </h3>
                        <x-wui-icon name="check-circle" class="w-6 h-6 text-green-500 dark:text-green-300"/>
                    </div>
                    <p class="text-gray-900 dark:text-gray-100">
                        {{ __('Your shortened link is') }}
                        <a href="{{ $shortenedUrl }}" target="_blank" class="underline">{{ $shortenedUrl }}</a>
                    </p>
                    <div class="mt-6 flex flex-wrap justify-between">
                        <x-secondary-button type="button" wire:click="success = false">
                            {{ __('Close') }}
                        </x-secondary-button>
                        <x-button type="button" @click="copy('{{ $shortenedUrl }}')">
                            {{ __('Copy') }}
                        </x-button>
                    </div>
                </div>
            </div>
        </x-modal>
    @endif

    <form class="p-4" wire:submit="short">
        <div class="mt-6">
            <x-label class="text-base">{{ __('Destination') }}</x-label>
            <x-input type="text" id="url" wire:model="url" class="w-full text-base py-3"
                     placeholder="https://example.com"/>
            <x-input-error for="url"/>
        </div>
        <div class="mt-2">
            <x-label class="text-base">{{ __('Custom back-half') }} <span
                    class="font-light">({{ __('optional') }})</span></x-label>
            <x-input type="text" id="url" wire:model="customSlug" class="w-full text-base py-3"/>
            <x-input-error for="customSlug"/>
        </div>
        <div class="mt-2">
            <x-label class="text-base">{{ __('Title') }} <span class="font-light">({{ __('optional') }})</span>
            </x-label>
            <x-input type="text" id="url" wire:model="title" class="w-full text-base py-3"/>
            <x-input-error for="title"/>
        </div>
        <div class="mt-2 flex justify-end">
            <x-button>{{ __('Save') }}</x-button>
        </div>
    </form>
</div>

<script>
    function alpineData() {
        return {
            copy(value) {
                new Toast({
                    message: '{{ __('Copied to clipboard') }}',
                    duration: 5000,
                    type: 'default',
                    position: 'top-end',
                });
                navigator.clipboard.writeText(value);
            }
        }
    }
</script>
