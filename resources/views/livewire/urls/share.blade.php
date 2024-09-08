<div x-data="{copy(el, value) {
                el.innerText = '{{ __('Copied') }}';
                setTimeout(() => {
                    el.innerText = '{{ __('Copy') }}';
                }, 2000);
                navigator.clipboard.writeText(value);
            }}">
    <x-wui-modal wire:model="show">
        <x-wui-card title="{{ __('Share your link') }}" class="w-full">
            <div class="flex flex-wrap gap-2 justify-start mx-auto">
                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://whatsapp.com' }}" alt="Whatsapp">
                        <a href="https://wa.me/?text={{ __('Check out this link shortened') }} {{ urlencode($shortened) }}"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">Whatsapp</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://facebook.com' }}" alt="Facebook">
                        <a href="https://facebook.com/sharer.php?u={{ urlencode($shortened) }}"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">Facebook</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://instagram.com' }}" alt="Instagram">
                        <a href="https://instagram.com"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">Instagram</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://x.com' }}" alt="X">
                        <a href="https://x.com/intent/tweet?text={{ __('Check out this link shortened') }} {{ urlencode($shortened) }}"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">X</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://threads.net' }}" alt="Threads">
                        <a href="https://www.threads.net/intent/post?text={{ __('Check out this link shortened') }} {{ urlencode($shortened) }}"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">Threads</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <x-heroicons::solid.envelope class="size-8 text-gray-600 dark:text-gray-400"/>
                        <a href="mailto:?subject={{ __('Check out my link').' '.$shortened }}&body={{ __('Check out this link shortened') }} {{ urlencode($shortened) }}"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">Threads</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://tiktok.com' }}" alt="TikTok">
                        <a href="https://www.tiktok.com"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">TikTok</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://linkedin.com' }}" alt="Linkedin">
                        <a href="https://www.linkedin.com/feed/?shareActive=true&text={{ __('Check out this link shortened') }} {{ urlencode($shortened) }}"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">Linkedin</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://youtube.com' }}" alt="Youtube">
                        <a href="https://www.youtube.com"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">Youtube</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://telegram.org' }}" alt="Telegram">
                        <a href="https://t.me/share/url?url={{ urlencode($shortened) }}&text={{ __('Check out this link shortened') }} {{ urlencode($shortened) }}"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">Telegram</p>
                </div>

                <div>
                    <div
                        class="relative size-16 ring-1 ring-gray-300 dark:ring-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-900 grid place-items-center">
                        <img src="{{ config('app.favicons').'https://messenger.com' }}" alt="Messenger">
                        <a href="https://www.messenger.com"
                           target="_blank" rel="nofollow" class="inset-0 absolute">
                        </a>
                    </div>
                    <p class="text-xs text-center mt-1">Messenger</p>
                </div>
            </div>
            <div class="mt-12 p-4">
                <div>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <x-input wire:model="shortened" class="w-full"/>
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <x-button type="button" @click="copy($el, '{{ $shortened }}')">Copy</x-button>
                        </div>
                    </div>
                </div>

            </div>
            <x-slot name="footer" class="flex justify-start gap-x-4">
                <x-wui-button secondary label="{{ __('Close') }}" x-on:click="close"/>
            </x-slot>
        </x-wui-card>
    </x-wui-modal>
</div>
