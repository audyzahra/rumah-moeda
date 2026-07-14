<?php

namespace App\Exports;

use App\Models\OrganizationStructure;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrganizationStructureExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OrganizationStructure::all();
    }
}
