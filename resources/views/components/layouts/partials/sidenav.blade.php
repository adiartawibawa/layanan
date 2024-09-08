<div>
    <div class="relative hidden h-full my-4 ml-4 lg:block">
        <aside
            class="flex flex-col w-64 rounded-md shadow-lg h-screen  px-5 pt-4 pb-6 overflow-y-auto no-scrollbar bg-white border-r rtl:border-r-0 rtl:border-l dark:bg-gray-900 dark:border-gray-700">
            <x-layouts.partials.menu />
        </aside>
    </div>
    <!-- Pop Out Navigation -->
    <aside id="mobile-navigation" class="fixed top-0 right-0 bottom-0 left-0 backdrop-blur-sm z-50"
        :class="openMenu ? 'visible' : 'invisible'" x-cloak>
        <!-- Close Button -->
        <button class="absolute top-0 right-0 bottom-0 left-0" @click="openMenu = !openMenu" :aria-expanded="openMenu"
            aria-controls="mobile-navigation" aria-label="Close Navigation Menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-2 right-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div :class="openMenu ? 'translate-x-0' : '-translate-x-full'"
            class="absolute top-0 left-0 bottom-0 drop-shadow-2xl z-50 transition-all flex flex-col w-64 h-screen px-5 py-8 overflow-y-auto no-scrollbar bg-white border-r rtl:border-r-0 rtl:border-l dark:bg-gray-900 dark:border-gray-700">
            <x-layouts.partials.menu />
        </div>
    </aside>
</div>
