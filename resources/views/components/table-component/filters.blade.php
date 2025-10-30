@props(['filter-options'])
<div id="accordion-collapse" data-accordion="open" class="mb-28 max-w-80">
    @foreach ($filterOptions['side_filters'] as $key => $value)
        <x-dynamic-component :component="'table-component.side-filters.' . $value['view_name']" :key="$key" :data="$value" />
    @endforeach
</div>