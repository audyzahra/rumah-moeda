<?php

namespace App\Exports;

use App\Models\OrganizationStructure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class OrganizationStructureExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    ShouldAutoSize,
    WithEvents,
    WithCustomStartCell,
    WithColumnWidths
{
    public function collection()
    {
        return OrganizationStructure::with('parent')
            ->orderBy('parent_id')
            ->orderBy('full_name')
            ->get()
            ->values()
            ->map(function ($item, $index) {

                return [
                    'No'        => $index + 1,
                    'Nama'      => $item->full_name,
                    'Jabatan'   => $item->position,
                    'Status'    => $item->parent_id ? 'Child' : 'Parent',

                    // hanya parent langsung
                    'Atasan'    => $item->parent
                        ? $item->parent->full_name
                        : '-',

                    'Deskripsi' => strip_tags($item->description),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Jabatan',
            'Status',
            'Atasan',
            'Deskripsi',
        ];
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 20,
            'C' => 20,
            'D' => 15,
            'E' => 20,
            'F' => 35,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Header tabel
        $sheet->getStyle('A4:F4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF'
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '4F81BD'
                ],
            ],

            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Border tabel
        $sheet->getStyle("A4:F{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Wrap text deskripsi
        $sheet->getStyle("F5:F{$lastRow}")
            ->getAlignment()
            ->setWrapText(true);

        // Tengah
        $sheet->getStyle("A5:E{$lastRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("A4:F{$lastRow}")
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | SHEET MASTER
                |--------------------------------------------------------------------------
                */

                $spreadsheet = $sheet->getParent();

                $master = new Worksheet($spreadsheet, 'MASTER');

                $spreadsheet->addSheet($master);

                // STATUS

                $master->setCellValue('A1', 'STATUS');
                $master->setCellValue('A2', 'Parent');
                $master->setCellValue('A3', 'Child');

                // ATASAN

                $master->setCellValue('C1', 'ATASAN');
                $master->setCellValue('C2', '-');

                $leaders = OrganizationStructure::orderBy('full_name')
                    ->pluck('full_name');

                $rowLeader = 3;

                foreach ($leaders as $leader) {

                    $master->setCellValue(
                        "C{$rowLeader}",
                        $leader
                    );

                    $rowLeader++;
                }

                $master->getStyle('A1:C1')
                    ->getFont()
                    ->setBold(true);

                $master->setSheetState(
                    Worksheet::SHEETSTATE_HIDDEN
                );

                /*
                |--------------------------------------------------------------------------
                | HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');

                $sheet->setCellValue(
                    'A1',
                    'RUMAH MOEDA'
                );

                $sheet->setCellValue(
                    'A2',
                    'DATA STRUKTUR ORGANISASI'
                );

                $sheet->setCellValue(
                    'A3',
                    'Tanggal Export : ' . now()->format('d-m-Y')
                );

                $sheet->getStyle('A1:A2')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 16,
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);

                $sheet->getRowDimension(4)->setRowHeight(25);

                /*
                |--------------------------------------------------------------------------
                | DROPDOWN
                |--------------------------------------------------------------------------
                */

                $lastRow = $sheet->getHighestRow();

                for ($i = 5; $i <= $lastRow + 50; $i++) {

                    // STATUS

                    $status = $sheet
                        ->getCell("D{$i}")
                        ->getDataValidation();

                    $status->setType(DataValidation::TYPE_LIST);
                    $status->setErrorStyle(DataValidation::STYLE_STOP);
                    $status->setAllowBlank(true);
                    $status->setShowDropDown(true);
                    $status->setFormula1("=MASTER!\$A\$2:\$A\$3");

                    // ATASAN

                    $leader = $sheet
                        ->getCell("E{$i}")
                        ->getDataValidation();

                    $leader->setType(DataValidation::TYPE_LIST);
                    $leader->setErrorStyle(DataValidation::STYLE_STOP);
                    $leader->setAllowBlank(true);
                    $leader->setShowDropDown(true);
                    $leader->setFormula1(
                        "=MASTER!\$C\$2:\$C\$" . ($rowLeader - 1)
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | FITUR EXCEL
                |--------------------------------------------------------------------------
                */


                // Freeze Header

                $sheet->freezePane('A5');
            }

        ];
    }
}
