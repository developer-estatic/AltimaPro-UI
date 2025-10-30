@props([
'model' => '',
'initials' => 'AB',
'avatar' => null
])

<div x-data="{
        previewUrl: null,
        avatar: $wire.entangle('avatar'),
        fileChosen(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                this.previewUrl = URL.createObjectURL(file);
            } else {
                this.previewUrl = null;
            }
        },
        init() {
        },
    }" x-init="init()"
    class="relative w-16 h-16 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center cursor-pointer"
    x-on:click="$refs.fileInput.click()">
    <input type="file" {{ $attributes->merge(['class' => 'absolute inset-0 w-full h-full opacity-0 cursor-pointer']) }}
    x-on:change="fileChosen"
    x-on:click.stop
    wire:model="{{ $model }}"
    x-ref="fileInput">
    @if($avatar)
    <img src="{{ is_object($avatar) ? $avatar->temporaryUrl() : asset('/assets/images/user/profile/' . $avatar) }}" alt="Preview" class="absolute inset-0 object-cover w-full h-full">
    @else
    <span class="text-2xl text-gray-600 font-semibold">{{ $initials }}</span>
    @endif
</div>