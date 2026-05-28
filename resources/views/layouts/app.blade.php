<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FoodOrder') }}</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div class="page-bg">
    @include('layouts.navigation')

    @if (isset($header))
    <div class="page-header">
        <div class="container">
            {{ $header }}
        </div>
    </div>
    @endif

    <main class="main-content">
        {{ $slot }}
    </main>
</div>
</body>
</html>
