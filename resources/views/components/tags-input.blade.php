@props(['label' => null, 'name', 'placeholder' => '', 'selected' => [], 'extra' => 'absolute'])

<div {{ $attributes->merge(['class' => 'flex-1']) }}
    x-data="{
        tags: @js(is_array($selected) ? $selected : (empty($selected) ? [] : [$selected])),
        search: '',
        addTag() {
            if (this.search.trim() !== '' && !this.tags.includes(this.search.trim())) {
                this.tags.push(this.search.trim());
                this.search = '';
                const fieldName = '{{ $name }}';
                $wire.dispatchSelf('setTagsInputValue', { value: this.tags, field: fieldName });
            }
        },
        removeTag(index) {
            this.tags.splice(index, 1);
            const fieldName = '{{ $name }}';
            $wire.dispatchSelf('setTagsInputValue', { value: this.tags, field: fieldName });
        }
    }">
    @if ($label)
    <label x-show="@js($label)" class="block mb-1 text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <div class="relative">
        <input type="hidden" name="{{ $name }}" :value="JSON.stringify(tags)">
        <div class="flex flex-wrap gap-1 mb-2!">
            <template x-for="(tag, idx) in tags" :key="idx">
                <div class="flex items-center bg-gray-100 border border-gray-300 rounded px-2 py-1 text-sm">
                    <span x-text="tag"></span>
                    <button type="button" class="ms-2 text-xl text-gray-500 hover:text-gray-700 -mt-1" @click="removeTag(idx)">&times;</button>
                </div>
            </template>
        </div>
        <input type="text"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
            autocomplete="false"
            :placeholder="'{{ $placeholder }}'"
            x-model="search"
            @keydown.enter.prevent="addTag()">
    </div>
</div>
