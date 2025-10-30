@php
extract(Flux::forwardedAttributes($attributes, [
    'name',
    'value',
    'placeholder',
]));
@endphp

@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'value' => null,
    'placeholder' => null,
])

@php
$classes = Flux::classes()
    ->add('w-full px-4 py-2 border rounded-md')
    ->add('focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500')
    ->add('text-sm text-gray-700')
    ->add('dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700')
    ;

[ $styleAttributes, $attributes ] = Flux::splitAttributes($attributes);
@endphp

<input
    {{ $styleAttributes->class($classes) }}
    type="text"
    {{ $attributes }}
    @if($name)name="{{ $name }}"@endif
    @if($value)value="{{ $value }}"@endif
    @if($placeholder)placeholder="{{ $placeholder }}"@endif
>