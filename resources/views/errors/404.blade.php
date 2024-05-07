@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('action')
    <a href="/" class="flex bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded justify-center">
        Go Home
    </a>
@endsection
