<?php

namespace App\Imports;

use App\Models\OrganizationStructure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class OrganizationStructureImport implements ToCollection, WithHeadingRow
{

    public function headingRow(): int
    {
        return 4;
    }


    public function collection(Collection $rows)
{

    // Tahap 1: Simpan semua data tanpa parent
    foreach ($rows as $row) {


        // Lewati baris kosong
        if (empty($row['nama'])) {
            continue;
        }


        // Cek duplikat
        $exists = OrganizationStructure::where('full_name', $row['nama'])
            ->where('position', $row['jabatan'])
            ->exists();


        if (!$exists) {

            OrganizationStructure::create([
                'full_name'   => $row['nama'],
                'position'    => $row['jabatan'],
                'photo'       => null,
                'description' => $row['deskripsi'] ?? null,
                'parent_id'   => null,
            ]);

        }
    }



    // Tahap 2: Hubungkan parent_id
    foreach ($rows as $row) {


        if (empty($row['nama'])) {
            continue;
        }


        $child = OrganizationStructure::where('full_name', $row['nama'])
            ->where('position', $row['jabatan'])
            ->first();


        if (!$child) {
            continue;
        }


        if (
            !empty($row['atasan']) &&
            $row['atasan'] != '-'
        ) {


            $parent = OrganizationStructure::where(
                'full_name',
                $row['atasan']
            )->first();



            if ($parent) {

                $child->update([
                    'parent_id' => $parent->id
                ]);

            }

        }
    }
}
}