<<<<<<< HEAD
@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div>
=======
﻿@if ($status)
<div {{ $attributes->merge(['class' => 'alert alert-success']) }}>
    {{ $status }}
</div>
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
@endif
