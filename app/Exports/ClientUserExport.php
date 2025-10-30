<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;



class ClientUserExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $columns;

    public function __construct(Collection $data, $columns)
    {
        $this->data = $data;
        $this->columns = $columns;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        foreach ($this->data as $key => $value) {
            $row = [];
            foreach ($this->columns as $column => $columnData) {
                if ($column == 'checkbox') {
                    continue;
                }

                $columnValue = null;

                // Check if the column has a 'data_key'
                if (isset($columnData['data_key'])) {
                    $dataKeyParts = explode('.', $columnData['data_key']);

                    // If the 'data_key' has multiple parts (indicating nested relation)
                    if (count($dataKeyParts) > 1) {
                        // Start from the root object
                        $columnValue = $value;

                        // Loop through each part of the data key to access nested relations
                        foreach ($dataKeyParts as $part) {
                            // Access the current relation dynamically
                            $columnValue = $columnValue->{$part} ?? null;
                            if (is_null($columnValue)) {
                                break; // If at any point the value is null, stop traversing
                            }
                        }
                    } else {
                        // Direct key, no relation
                        $columnValue = $value->{$columnData['data_key']} ?? null;
                    }
                }
                $row[] = $columnValue;
            }
            $data[] = $row;
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'TP Account Number',
            'Email',
            'Client Name',
            'Created On',
            'Currency',
            'Leverage',
            'Platform Name',
            'Total Withdrawl',
            'Total Deposit',
            'Owner',
            'Type',
        ];
    }
}
