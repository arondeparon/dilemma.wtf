@extends('layouts.app')

@section('title')
    {{ $dilemma1 }} or {{ $dilemma2 }}? - Dilemma.wtf
@endsection

@section('content')
<div class="flex flex-col items-center justify-center h-screen text-8xl lg:text-9xl">
    <div class="font-bold text-center text-gray-800">
        {{ $dilemma1 }}
    </div>
    <div class="text-6xl text-gray-300">
        or
    </div>
    <div class="font-bold text-center text-gray-500">
        {{ $dilemma2 }}
    </div>
    <div class="lg:mt-16 text-lg flex space-x-4 items-center">
        <div x-data="{ copied: false }" class="relative">
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
               class="text-blue-500 underline">
                Share this dilemma
            </a>
            <div x-cloak x-show="copied"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="transform opacity-0 translate-y-2"
                 x-transition:enter-end="transform opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="transform opacity-100 translate-y-0"
                 x-transition:leave-end="transform opacity-0 translate-y-2"
                 class="absolute left-0 mt-2 py-2 px-4 bg-blue-100 text-blue-800 rounded-lg shadow-lg">
                Copied!
            </div>
        </div>


        <a href="/" class="text-blue-500 underline">Give me another one</a>
        <a href="https://github.com/arondeparon/dilemma.wtf" target="_blank" class="text-slate-800 hover:text-slate-600">
            <span class="sr-only">GitHub</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
            </svg>
        </a>
    </div>
</div>
@endsection
