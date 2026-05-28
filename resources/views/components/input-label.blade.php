<<<<<<< HEAD
@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
=======
﻿<label {{ $attributes->merge(['class' => 'form-label']) }}>{{ $value ?? $slot }}</label>
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
