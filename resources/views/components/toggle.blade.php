@props([
    'options' => [],
    'value' => null,
    'update' => null,
])
<label class="inline-flex! items-center me-5 cursor-pointer">
    <input type="checkbox" value="1" class="sr-only peer" {{ $value == 1 ? 'checked' : '' }} {{ $update }} />
    <div
        class="relative w-12! h-6 rounded-full peer peer-focus:ring-4 {{ $value == 1 ? 'bg-green-600 peer-focus:ring-green-300' : 'bg-gray-200 peer-focus:ring-gray-300' }}">
        <div
            class="absolute top-0.5 start-[2px] h-5 w-5 rounded-full border transition-all {{ $value == 1 ? 'translate-x-full bg-white border-white' : 'bg-white border-gray-300' }}">
        </div>
    </div>
    <span class="ms-3 text-sm font-medium text-gray-900">{{ $value == 1 ? $options[1] : $options[0] }}</span>
</label>
