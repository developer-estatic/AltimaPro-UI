@props(['label' => null, 'name', 'placeholder' => '', 'options', 'selected' => '', 'multiple' => false, 'extra' => 'absolute'])

<div {{ $attributes->merge(['class' => 'flex-1']) }}
    x-data="{
        optionsVisible: false,
        search: '',
        multiple: @js($multiple),
        selected: @js($multiple ? [] : (is_array($selected) ? ($selected[0] ?? null) : $selected)),
        options: @js($options),
        highlightedIndex: -1,
        clearSearch() {
            if (this.multiple) {
                this.selected = [];
            } else {
                this.selected = null;
            }
            this.search = '';
            const selectedValue = this.multiple ? [] : null;
            const fieldName = '{{ $name }}';
            $wire.dispatchSelf('setComboBoxValue', { value: selectedValue, field: fieldName });
            this.hideOptions();
        },
        setInitial(selected) {
            if (this.multiple) {
                let selectedArr = Array.isArray(selected) ? selected : (selected ? [selected] : []);
                this.selected = [];
                for (let i = 0; i < selectedArr.length; i++) {
                    let selectedOption = this.options.find(option => option.id == selectedArr[i]);
                    if (selectedOption !== undefined) {
                        this.selected.push(selectedOption);
                    }
                }
            } else {
                let selectedOption = this.options.find(option => option.id == selected);
                if (selectedOption !== undefined) {
                    this.selectOption(selectedOption);
                }
            }
        },
        showOptions() {
            this.optionsVisible = true;
            this.highlightedIndex = 0;
        },
        hideOptions() {
            this.optionsVisible = false;
            this.highlightedIndex = -1;
        },
        selectOption(option) {
            if (this.multiple) {
                if (!this.selected.some(o => o.id === option.id)) {
                    this.selected.push(option);
                }
                this.search = '';
                this.showOptions();
                const selectedValue = this.selected.map(o => o.id);
                const fieldName = '{{ $name }}';
                $wire.dispatchSelf('setComboBoxValue', { value: selectedValue, field: fieldName });
            } else {
                this.selected = option;
                this.search = '';
                const selectedValue = option.id;
                const fieldName = '{{ $name }}';
                $wire.dispatchSelf('setComboBoxValue', { value: selectedValue, field: fieldName });
            }
            this.optionsVisible = false;
            this.highlightedIndex = -1;

            // Forcefully trigger click.outside to ensure options are hidden
            const comboboxDiv = this.$refs.comboboxdiv;
            if (comboboxDiv) {
                comboboxDiv.dispatchEvent(new CustomEvent('click.outside', { bubbles: true }));
            }
        },
        removeOption(index) {
            if (this.multiple) {
                this.selected.splice(index, 1);
                const selectedValue = this.selected.map(o => o.id);
                const fieldName = '{{ $name }}';
                $wire.dispatchSelf('setComboBoxValue', { value: selectedValue, field: fieldName });
            }
        },
        filteredOptions() {
            if (this.multiple) {
                if(this.search) {
                    return this.options.filter(option =>
                        option.name.toLowerCase().includes(this.search.toLowerCase()) &&
                        !this.selected.some(sel => sel.id === option.id)
                    );
                } else {
                    return this.options;
                }
            }
            if(this.search) {
                return this.options.filter(option =>
                    option.name.toLowerCase().includes(this.search.toLowerCase())
                );
            } else {
                return this.options;
            }
        },
        highlight(value) {
            let text = this.search.trim();
            if (text === '') { return value; }
            let query = new RegExp('(' + text + ')', 'ig');
            return value.replace(query, '$1');
        }
    }"
    x-init="$nextTick(() => setInitial(@js($selected)))">
    @if ($label)
    <label x-show="@js($label)" class="block mb-1 text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <div class="relative">
        <template x-if="multiple">
            <input type="hidden" name="{{ $name }}" :value="JSON.stringify(selected.map(o => o.id))">
        </template>
        <template x-if="!multiple">
            <input type="hidden" name="{{ $name }}" :value="selected?.id">
        </template>
        <template x-if="multiple">
            <div class="flex flex-wrap gap-1 mb-1" x-show="multiple && selected.length">
                <template x-for="(item, idx) in selected" :key="idx">
                    <div class="flex! items-center! bg-gray-100 border border-gray-300 rounded px-2 py-1 text-sm mr-1 mb-1">
                        <span x-text="item.name"></span>
                        <button type="button" class="ms-2 text-xl! text-gray-500 hover:text-gray-700 -mt-1!" @click="removeOption(idx)">&times;</button>
                    </div>
                </template>
            </div>
        </template>

        <div class="relative comboboxdiv" ref="comboboxdiv" @click.outside="optionsVisible = false">
            <input type="text"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                autocomplete="false"
                :placeholder="multiple && selected.length ? '' : '{{ $placeholder }}'"
                x-model="search"
                @focus="search = ''; showOptions()"
                @input="optionsVisible = true"
                :value="search.length ? search : (multiple ? '' : (selected ? selected.name : ''))"
                @keydown.enter.prevent="if(filteredOptions().length > 0 && highlightedIndex >= 0) selectOption(filteredOptions()[highlightedIndex])"
                @keydown.arrow-down.prevent="if(filteredOptions().length - 1 > highlightedIndex) highlightedIndex++"
                @keydown.arrow-up.prevent="if(highlightedIndex > 0) highlightedIndex--"
            >
            <div x-show="optionsVisible" class="z-10 w-full bg-white rounded-lg mt-1 max-h-60! overflow-auto shadow-lg {{ $extra }}">
                <template x-for="(option, idx) in filteredOptions()" :key="option.id">
                    <div @click="selectOption(option);" class="px-4 py-2 cursor-pointer hover:bg-blue-100" :class="{'bg-blue-50': highlightedIndex === idx, 'bg-blue-200': !multiple && selected?.id === option.id}">
                        <span x-html="highlight(option.name)"></span>
                    </div>
                </template>
                <div x-show="filteredOptions().length === 0" class="px-4 py-2 text-gray-400">No matches found</div>
            </div>
            <button type="button"
                @click="clearSearch()"
                class="absolute right-2 top-2 text-gray-400 hover:text-gray-600 text-2xl"
                x-show="!multiple && selected"
            >
                &times;
            </button>
        </div>
    </div>
</div>
