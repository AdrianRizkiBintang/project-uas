@php $isError = isset($attributes['class']) && str_contains($attributes['class'], 'border-red'); @endphp
<input {{ $attributes->merge(['class' => 'form-input']) }}>
