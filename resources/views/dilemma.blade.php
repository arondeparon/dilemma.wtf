@extends('layouts.app')

@section('title')
    {{ trim($dilemma1) }} or {{ trim($dilemma2) }} - What would you choose? - Dilemma.wtf
@endsection

@section('content')
    <div x-cloak class="relative flex flex-col justify-between h-dvh dark:bg-gray-800" x-data="{ infoOpen: false }">
        <!-- Info Button -->
        <button @click="infoOpen = true"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
            <span class="sr-only">Information</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
            </svg>
        </button>

        <!-- Info Overlay -->
        <div x-cloak x-show="infoOpen" x-transition
             class="fixed inset-0 z-50 flex items-start justify-center bg-black/70 p-6"
             @keydown.escape.window="infoOpen = false" @click.self="infoOpen = false">
            <div class="mt-16 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 p-6 rounded-lg max-w-xl w-full space-y-4 text-left">
                <p class="text-lg">Dilemma.wtf throws you two absurd choices. Pick the one you'd rather stomach, see how the crowd voted, then hit Next for another. No logins, no prizes - just weird fun.</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">This site is open source. You can browse the code and even add new dilemmas or improvements yourself on GitHub.</p>
                <div class="flex items-center justify-between">
                    <a href="https://github.com/arondeparon/dilemma.wtf" target="_blank" class="text-blue-500 hover:text-blue-600">View the code on GitHub</a>
                    <button @click="infoOpen = false" class="px-4 py-2 bg-blue-500 text-white rounded">Got it</button>
                </div>
            </div>
        </div>

        <!-- Dilemmas Content -->
        <div class="flex flex-col items-center justify-center flex-grow px-12 text-center" x-data="voter">
            <a class="font-bold text-5xl md:text-8xl lg:text-9xl transform transition-all hover:scale-105"
               id="first"
               href="#"
               :class="{
               'text-gray-800 dark:text-white': selected !== 'first',
               'text-green-500 dark:text-green-400': selected === 'first'
               }"
               @click.prevent="vote('first')"
            >
                {{ $dilemma1 }}
            </a>
            <div class="text-6xl text-gray-300 dark:text-gray-500">
                or
            </div>
            <a class="font-bold text-5xl md:text-8xl lg:text-9xl transform transition-all hover:scale-105"
               id="second"
               href="#"
               :class="{
               'text-gray-500 dark:text-gray-400': selected !== 'second',
               'text-green-500 dark:text-green-400': selected === 'second'
               }"
               @click.prevent="vote('second')"
            >
                {{ $dilemma2 }}
            </a>
        </div>

        <!-- Footer Actions -->
        <div class="p-4">
            <div class="lg:mt-16 text-lg flex space-x-4 items-center justify-between">
                <div class="flex flex-1 justify-center space-x-4">
                    <div x-data="{ copied: false }" class="relative">
                        <div x-cloak x-show="copied"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="transform opacity-0 translate-y-2"
                             x-transition:enter-end="transform opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="transform opacity-100 translate-y-0"
                             x-transition:leave-end="transform opacity-0 translate-y-2"
                             class="absolute w-60 left-0 -top-16 mt-2 py-2 px-4 bg-blue-100 text-blue-800 rounded-lg shadow-lg">
                            URL copied to clipboard!
                        </div>
                        <a href="#"
                           @click.prevent="
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText('{{ route('dilemma', ['hash' => $hash]) }}')
                                .then(() => {
                                    copied = true;
                                    setTimeout(() => { copied = false; }, 3000);
                                })
                                .catch(e => console.error('Copy failed', e));
                        } else {
                            console.error('Clipboard not available');
                        }"
                           class="text-blue-400">
                            Share this dilemma
                        </a>
                    </div>
                    <span class="text-gray-400">•</span>
                    <a id="reload" href="/" class="text-blue-400">Next</a>
                    <span class="text-gray-400">•</span>
                    <a href="{{ route('ranking') }}" class="text-blue-400">Stats</a>
                    <span class="text-gray-400 hidden lg:inline">•</span>
                    <span class="hidden lg:inline text-sm text-gray-500">Keyboard shortcuts:
                        <kbd class="px-2 py-1 text-lg font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">↑</kbd> - first,
                        <kbd class="px-2 py-1 text-lg font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">↓</kbd> - second,
                        <kbd class="px-2 py-1 text-lg font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"d>→</kbd> - next
                    </span>
                </div>
                <a href="https://github.com/arondeparon/dilemma.wtf" target="_blank" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <span class="sr-only">GitHub</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('voter', () => ({
                selected: null,
                vote(option) {
                    this.selected = option;
                    axios.post('{{ action(\App\Http\Controllers\VoteController::class, $hash) }}', {
                        'vote': option,
                    })
                }
            }));

            // Use arrow up to select first, arrow down to select second and enter to reload page
            document.addEventListener('keydown', function(event) {
                const caughtKeys = ['ArrowUp', 'ArrowDown', 'ArrowRight', 'Enter'];

                if (!caughtKeys.includes(event.key)) {
                    return;
                }

                if (event.key === 'ArrowUp') {
                    document.getElementById('first').click();
                } else if (event.key === 'ArrowDown') {
                    document.getElementById('second').click();
                } else if ([ 'ArrowRight', 'Enter' ].includes(event.key)) {
                    document.getElementById('reload').click();
                }

                event.preventDefault();
            });
        });
    </script>
@endsection
