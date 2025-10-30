@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-bold mb-0">Business Units</h3>
            @if(canPerformAction('settings.business-units.create'))
            <flux:tooltip content="Add Business Unit" extra-classes="px-2!">
                <flux:button size="sm" variant="primary" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>

        <x-modal name="create-update-business-unit">
            @if ($modalVisible)
            <form wire:submit.prevent="saveBusinessUnit">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Brand</flux:label>
                        <flux:description>Select the brand for this business unit.</flux:description>
                        <x-combobox label="" name="brand_id" placeholder="Select Brand" :options="$brandOptions" :selected="$brand_id" :multiple="false" />
                        <flux:error name="brand_id" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Is Parent</flux:label>
                        <flux:description>Specify if this is a parent business unit.</flux:description>
                        <x-toggle :options="['No', 'Yes']" :value="$isparent" :update="'wire:model.live=isparent'" />
                        <flux:error name="isparent" />
                    </flux:field>
                </div>

                @if (!$isparent)
                <div class="p-4">
                    <flux:field>
                        <flux:label>Parent Business Unit</flux:label>
                        <flux:description>Select the parent business unit.</flux:description>
                        <x-combobox label="" name="parent_business_unit_id" placeholder="Select Parent"
                            :options="$parentBusinessUnitOptions"
                            :selected="$parent_business_unit_id" :multiple="false" />
                        <flux:error name="parent_business_unit_id" />
                    </flux:field>
                </div>
                @endif

                <div class="p-4">
                    <flux:field>
                        <flux:label>Name</flux:label>
                        <flux:description>Enter the name of the business unit.</flux:description>
                        <flux:input placeholder="Enter Name" wire:model.defer="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:description>Set the status of the business unit (Active/Inactive).</flux:description>
                        <x-toggle :options="['Inactive', 'Active']" :value="$status"
                            :update="'wire:model.live=status'" />
                        <flux:error name="status" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Timezone</flux:label>
                        <flux:description>Enter the timezone of the business unit.</flux:description>
                        <flux:input placeholder="Enter Timezone" wire:model.defer="timezone" />
                        <flux:error name="timezone" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Language</flux:label>
                        <flux:description>Enter the language of the business unit.</flux:description>
                        <flux:input placeholder="Enter Language" wire:model.defer="language" />
                        <flux:error name="language" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>FTD Amount</flux:label>
                        <flux:description>Enter the FTD amount for the business unit.</flux:description>
                        <flux:input placeholder="Enter FTD Amount" wire:model.defer="ftd_amount" />
                        <flux:error name="ftd_amount" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Partial FTD</flux:label>
                        <flux:description>Specify if partial FTD is allowed.</flux:description>
                        <x-toggle :options="['No', 'Yes']" :value="$partial_ftd"
                            :update="'wire:model.live=partial_ftd'" />
                        <flux:error name="partial_ftd" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>S3 Bucket Name</flux:label>
                        <flux:description>Enter the S3 bucket name for the business unit.</flux:description>
                        <flux:input placeholder="Enter S3 Bucket Name" wire:model.defer="s3_bucket_name" />
                        <flux:error name="s3_bucket_name" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>S3 Bucket Path</flux:label>
                        <flux:description>Enter the S3 bucket path for the business unit.</flux:description>
                        <flux:input placeholder="Enter S3 Bucket Path" wire:model.defer="s3_bucket_path" />
                        <flux:error name="s3_bucket_path" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Is Pamm</flux:label>
                        <flux:description>Specify if this is a Pamm business unit.</flux:description>
                        <x-toggle :options="['No', 'Yes']" :value="$ispamm" :update="'wire:model.live=ispamm'" />
                        <flux:error name="ispamm" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Is Social</flux:label>
                        <flux:description>Specify if this is a Social business unit.</flux:description>
                        <x-toggle :options="['No', 'Yes']" :value="$issocial" :update="'wire:model.live=issocial'" />
                        <flux:error name="issocial" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Is Prop</flux:label>
                        <flux:description>Specify if this is a Prop business unit.</flux:description>
                        <x-toggle :options="['No', 'Yes']" :value="$isprop" :update="'wire:model.live=isprop'" />
                        <flux:error name="isprop" />
                    </flux:field>
                </div>
                <div class="p-4 flex justify-end">
                    <flux:button wire:click="hideModal" variant="subtle">Cancel</flux:button>
                    <flux:button variant="primary" type="submit" class="rounded hover:bg-persian-green">Save</flux:button>
                </div>
            </form>
            @endif
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
            <table class="w-full text-left rtl:text-right text-gray-600">
                <thead class="uppercase bg-gray-300">
                    <tr>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Brand</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Name</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Status</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Timezone</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Language</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Is Parent</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">FTD Amount</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Is Pamm</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Is Social</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Is Prop</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">S3 Bucket Name</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">S3 Bucket Path</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Partial FTD</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Parent Business Unit</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 w-20">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($businessUnits as $unit)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->brand->name ?? 'N/A' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->status ? $activeLabel : $inactiveLabel }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->timezone }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->language }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->isparent ? 'Yes' : 'No' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->ftd_amount }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->ispamm ? 'Yes' : 'No' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->issocial ? 'Yes' : 'No' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->isprop ? 'Yes' : 'No' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->s3_bucket_name }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->s3_bucket_path }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->partial_ftd ? 'Yes' : 'No' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $unit->parent->name ?? 'N/A' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex gap-2">
                                <flux:tooltip content="Edit Business Unit">
                                    <flux:button variant="outline" square size="sm" class="border bg-blue-700/70! text-white! rounded-md" wire:click="editBusinessUnit({{ $unit->id }})">
                                        <i class="fas fa-edit"></i>
                                </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete Business Unit">
                                    <flux:button variant="outline" square size="sm" class="border bg-red-500! text-white! rounded-md" wire:click="deleteBusinessUnit({{ $unit->id }})">
                                        <i class="fas fa-trash"></i>
                                    </flux:button>
                                </flux:tooltip>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>