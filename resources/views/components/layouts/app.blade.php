<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>

    <body class="min-h-screen bg-[#F4F6F8] antialiased">

    <div class="max-w-5xl mx-auto pt-16 pb-24">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                Найдите идеальный перелёт ✈️
            </h1>
            <p class="mt-2 text-gray-500 text-lg">
                Реалистичный билет для путешествия или визовых задач
            </p>
        </div>

        <div class="bg-white shadow-xl rounded-2xl p-10">
            {{ $slot }}
        </div>
    </div>

        @livewire('notifications')

        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
