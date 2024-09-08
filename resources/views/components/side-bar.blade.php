<aside x-data="{ open: false }" @keydown.window.escape="open = false" class="bg-gray-100 dark:bg-neutral-900">

    <div x-show="open" class="relative z-50 lg:hidden"
         x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." x-ref="dialog"
         aria-modal="true" style="display: none;">

        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0" class="fixed inset-0 bg-neutral-900/80"
             x-description="Off-canvas menu backdrop, show/hide based on off-canvas menu state." aria-hidden="true"
             style="display: none;"></div>


        <div class="fixed inset-0 flex">

            <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                 x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                 class="relative mr-16 flex w-full max-w-xs flex-1" @click.away="open = false" style="display: none;">

                <div x-show="open" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     x-description="Close button, show/hide based on off-canvas menu state."
                     class="absolute left-full top-0 flex w-16 justify-center pt-5" style="display: none;">
                    <button type="button" class="-m-2.5 p-2.5" @click="open = false">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-neutral-900 px-6 pb-4">
                    <div class="flex h-16 shrink-0 items-center">
                        <a href="{{ route('dashboard') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>
                    <livewire:components.side-bar-menu/>
                </div>
            </div>

        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r dark:border-neutral-800 bg-white dark:bg-neutral-900 px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-mark class="block h-8 w-auto" />
                </a>
            </div>
            <livewire:components.side-bar-menu/>
        </div>
    </div>

    <div class="lg:pl-72 h-screen overflow-hidden">
        <div class="sticky top-0 z-40 lg:mx-auto">
            <div class="flex h-16 items-center gap-x-4 border-b dark:border-neutral-800 bg-white dark:bg-neutral-900 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-0 lg:shadow-none">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 dark:text-gray-300 lg:hidden" @click="open = true">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-200 dark:bg-gray-800 lg:hidden" aria-hidden="true"></div>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    @livewire('navigation-menu')
                </div>
            </div>
        </div>

        <main class="h-[calc(100vh-4rem)] overflow-auto max-h-full flex flex-col w-full b-scroll">
            <div class="size-full mx-auto flex-1 flex flex-col">
                {{ $slot }}
            </div>
        </main>
    </div>
</aside>
