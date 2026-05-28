<<<<<<< HEAD
@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
=======
﻿@php $isError = isset($attributes['class']) && str_contains($attributes['class'], 'border-red'); @endphp
<input {{ $attributes->merge(['class' => 'form-input']) }}>
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
