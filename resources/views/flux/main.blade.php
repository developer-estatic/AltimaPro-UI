@props([
    'container' => null,
    'padding' => 'p-6 lg:p-8', // Default padding
])

@php
$classes = Flux::classes('[grid-area:main]')
    ->add($padding)
    ->add('[[data-flux-container]_&]:px-0') // If there is a wrapping container, let IT handle the x padding...
    ->add($container ? 'mx-auto w-full [:where(&)]:max-w-7xl' : '')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-main>
    {{ $slot }}
</div>
