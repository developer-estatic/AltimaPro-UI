@props([
'id',
'label' => null,
'type' => 'text',
'required' => false,
'model' => null,
'placeholder' => '',
'classInput' => ''
])

@php
$inputId = $id ?? $attributes->get('id');
$isRequired = $required ? 'required' : '';
@endphp

<div class="relative w-full">
    <input type="{{ $type }}" id="{{ $inputId }}" {{ $isRequired }} @if($model) wire:model="{{ $model }}" @endif
        placeholder="{{ $placeholder }}" {{ $attributes->class([
    'ps-0 peer h-10 mt-2 w-full border-0! border-b-2! text-gray-900 placeholder-gray-400 focus:outline-none
    focus:ring-0',
    'border-b-gray-200 focus:border-sky-500' => !$errors->has($inputId),
    'border-b-red-500 focus:border-red-500' => $errors->has($inputId),
    ]) }}
    />

    @if($label)
    <label for="{{ $inputId }}" {{ $attributes->class([
        'absolute left-0 -top-3.5 text-sm transition-all peer-focus:font-medium',
        'text-gray-400 peer-focus:text-sky-500' => !$errors->has($model),
        'text-red-500 peer-focus:text-red-500' => $errors->has($model),
        ]) }}>
        {{ $label }}@if($required)<span class="ms-1 text-red-500">*</span>@endif
    </label>
    @endif

    @error($model)
    <span class="relative left-0 top-[20px] text-red-500 text-xs mt-1 block">{{ $message }}</span>
    @enderror
</div>