<?php

namespace App\Imports;

use App\Models\OrganizationStructure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrganizationStructureImport implements ToModel, WithHeadingRow
{
    public function headingRow(): int
    {
        return 4;
    }

    public function model(array $row)
    {
        $parentId = null;

        // Cari atasan berdasarkan nama
        if (!empty($row['atasan']) && $row['atasan'] != '-') {

            $parent = OrganizationStructure::where('full_name', $row['atasan'])->first();

            if ($parent) {
                $parentId = $parent->id;
            }
        }

        // ===========================
        // Cek apakah data sudah ada
        // ===========================
        $exists = OrganizationStructure::where('full_name', $row['nama'])
            ->where('position', $row['jabatan'])
            ->exists();

        if ($exists) {
            return null; // Skip jika sudah ada
        }

        // Simpan jika belum ada
        return new OrganizationStructure([
            'parent_id'   => $parentId,
            'full_name'   => $row['nama'],
            'position'    => $row['jabatan'],
            'photo'       => null,
            'description' => $row['deskripsi'],
        ]);
    }
}