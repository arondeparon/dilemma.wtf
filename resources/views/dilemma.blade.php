@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center h-screen text-9xl">
    <div class="font-bold text-center">
        {{ $dilemma1 }}
    </div>
    <div class="text-6xl text-gray-300">
        or
    </div>
    <div class="font-bold text-center">
        {{ $dilemma2 }}
    </div>
</div>
@endsection
