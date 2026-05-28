<<<<<<< HEAD
@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
=======
﻿@if ($messages)
<ul class="form-error">
    @foreach ((array) $messages as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
@endif
