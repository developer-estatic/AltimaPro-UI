@props(['data', 'table-head-columns', 'search', 'conditions', 'filter-options'])
<div>
    <div x-data="{
        selectedRows: [],
        toggleSelectAll() {
            let row_checkboxs = document.querySelectorAll('.row_checkbox');
            if (this.selectedRows.length == row_checkboxs.length) {
                this.selectedRows = []
            } else {
                for (let i = 0; i < row_checkboxs.length; i++) {
                    const value = row_checkboxs[i]?.value;
                    if (value && !this.selectedRows.includes(value)) {
                        this.selectedRows.push(value)
                    }
                }
            }
        },
        addRemoveFromSelection(value) {
            if (this.selectedRows.includes(value)) {
                this.selectedRows = this.selectedRows.filter(item => item !== value);
            } else {
                this.selectedRows.push(value);
            }
        },
        sendToLivewire() {}
    }">
        <div class="p-3 rounded-lg">
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <div x-show="selectedRows.length">
                        <x-table-component.top-left-actions />
                    </div>
                </div>
                <div class="flex gap-2">
                    <x-table-component.search :search="$search" wire:model="search" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <x-table-component.filters :filter-options="$filterOptions" />
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable">
                        <thead>
                            <x-table-component.table-head :conditions='$conditions' :columns="$tableHeadColumns"
                                :filter-options="$filterOptions" :records-length="count($data)" />
                        </thead>
                        <tbody>
                            <x-table-component.table-rows :checkbox="true" :columns="$tableHeadColumns"
                                :data="$data" />
                        </tbody>
                    </table>
                </div>

                @if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator && $data->hasPages())
                <div class="box-footer clearfix">
                    {{ $data->links() }}
                </div>
                @elseif($data instanceof \Illuminate\Pagination\LengthAwarePaginator && !$data->hasPages())
                <div class="box-footer">
                    <p class="text-muted">
                        @if ($data->total() > 0)
                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }}
                        results
                        @endif
                    </p>
                </div>
                @else
                <div class="box-footer">
                    <p class="text-muted">
                        @if (count($data) > 0)
                        {{ count($data) }} result{{ count($data) > 1 ? 's' : '' }} Found
                        @endif
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>