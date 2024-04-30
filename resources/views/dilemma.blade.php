@extends('layouts.app')

@section('title')
    {{ $dilemma1 }} or {{ $dilemma2 }}? - Dilemma.wtf
@endsection

@section('content')
<div class="flex flex-col items-center justify-center h-screen text-8xl lg:text-9xl">
    <div class="font-bold text-center">
        {{ $dilemma1 }}
    </div>
    <div class="text-6xl text-gray-300">
        or
    </div>
    <div class="font-bold text-center">
        {{ $dilemma2 }}
    </div>
    <div class="lg:mt-16 text-lg flex space-x-4">
        <a href="{{ route('dilemma', ['hash' => $hash]) }}" class="text-blue-500 underline">Share this dilemma</a>
        <a href="/" class="text-blue-500 underline">Give me another one</a>
    </div>
</div>
@endsection
