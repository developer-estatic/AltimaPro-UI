<div
    class="z-10 fixed inset-0 bg-black/10 hidden
        [[data-show-stashed-sidebar]_&]:block
        [[data-show-table-filters-stashed-sidebar]_&]:block
        lg:[[data-show-stashed-sidebar]_&]:hidden
        lg:[[data-show-table-filters-stashed-sidebar]_&]:hidden"
    x-data
    x-on:click="document.body.removeAttribute('data-show-stashed-sidebar'); document.body.removeAttribute('data-show-table-filters-stashed-sidebar');"
></div>
