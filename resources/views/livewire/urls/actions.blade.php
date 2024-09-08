<div>
    <x-modal wire:model="_isDeleting">
        <div class="bg-white dark:bg-neutral-800 p-4 rounded-lg">
            <h4 class="text-2xl font-semibold text-black dark:text-white">{{ __('Delete link?') }}</h4>

            <p class="text-gray-900 dark:text-gray-100 my-4">
                After deleting a link, it will no longer be available for redirection. Are you sure you want to delete this link?
            </p>

            <div class="flex justify-end gap-2 sm:gap-4 md:gap-6">
                <x-secondary-button type="button" wire:click="_isDeleting=false">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button type="button" wire:click="confirmDelete">
                    {{ __('Delete link') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>

    <livewire:urls.share/>
</div>
