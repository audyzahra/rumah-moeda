<?php

namespace App\Exports;

use App\Models\OrganizationStructure;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;



class OrganizationStructureTemplateExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    ShouldAutoSize,
    WithEvents,
    WithCustomStartCell,
    WithColumnWidths
{


    /*
    |--------------------------------------------------------------------------
    | DATA TEMPLATE KOSONG
    |--------------------------------------------------------------------------
    |
    | Karena ini template import,
    | kita tidak mengambil data dari database.
    |
    | Kita menyediakan 100 baris kosong
    | yang siap diisi user.
    |
    */

    public function array(): array
    {

        $rows = [];


        for($i = 0; $i < 100; $i++){

            $rows[] = [

                '', // Nama
                '', // Jabatan
                '', // Status
                '', // Atasan
                '', // Deskripsi

            ];

        }


        return $rows;

    }



    /*
    |--------------------------------------------------------------------------
    | HEADER EXCEL
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {

        return [

            'Nama',
            'Jabatan',
            'Status',
            'Atasan',
            'Deskripsi'

        ];

    }




    /*
    |--------------------------------------------------------------------------
    | POSISI HEADER TABLE
    |--------------------------------------------------------------------------
    */

    public function startCell(): string
    {

        return 'A7';

    }





    /*
    |--------------------------------------------------------------------------
    | UKURAN KOLOM
    |--------------------------------------------------------------------------
    */

    public function columnWidths(): array
    {

        return [

            'A' => 25,
            'B' => 25,
            'C' => 15,
            'D' => 25,
            'E' => 40,

        ];

    }





    /*
    |--------------------------------------------------------------------------
    | STYLE EXCEL
    |--------------------------------------------------------------------------
    */

    public function styles(Worksheet $sheet)
    {


        /*
        |--------------------------------------------------------------------------
        | HEADER TABLE
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle('A7:E7')
        ->applyFromArray([


            'font'=>[

                'bold'=>true,

                'color'=>[

                    'rgb'=>'FFFFFF'

                ],

            ],


            'fill'=>[

                'fillType'=>Fill::FILL_SOLID,

                'startColor'=>[

                    'rgb'=>'4F81BD'

                ],

            ],



            'alignment'=>[

                'horizontal'=>Alignment::HORIZONTAL_CENTER,

                'vertical'=>Alignment::VERTICAL_CENTER,

            ],


        ]);






        /*
        |--------------------------------------------------------------------------
        | BORDER TABLE
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle('A7:E107')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(
            Border::BORDER_THIN
        );






        /*
        |--------------------------------------------------------------------------
        | CENTER ALIGNMENT
        |--------------------------------------------------------------------------
        */


        $sheet->getStyle('A8:D107')
        ->getAlignment()
        ->setHorizontal(
            Alignment::HORIZONTAL_CENTER
        );



        /*
        |--------------------------------------------------------------------------
        | WRAP DESKRIPSI
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('E8:E107')
        ->getAlignment()
        ->setWrapText(true);



        /*
        |--------------------------------------------------------------------------
        | TINGGI HEADER
        |--------------------------------------------------------------------------
        */

        $sheet->getRowDimension(7)
        ->setRowHeight(25);



    }



        /*
    |--------------------------------------------------------------------------
    | EVENT EXCEL
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {

        return [

            AfterSheet::class => function(AfterSheet $event){


                $sheet = $event
                    ->sheet
                    ->getDelegate();



                $spreadsheet = $sheet->getParent();



                /*
                |--------------------------------------------------------------------------
                | HEADER TEMPLATE
                |--------------------------------------------------------------------------
                */


                $sheet->mergeCells('A1:E1');

                $sheet->mergeCells('A2:E2');

                $sheet->mergeCells('A3:E3');

                $sheet->mergeCells('A5:E5');

                $sheet->mergeCells('A6:E6');



                $sheet->setCellValue(
                    'A1',
                    'TEMPLATE IMPORT STRUKTUR ORGANISASI'
                );


                $sheet->setCellValue(
                    'A2',
                    'RUMAH MOEDA'
                );


                $sheet->setCellValue(
                    'A3',
                    'Isi data mulai baris ke-8'
                );



                $sheet->setCellValue(
                    'A5',
                    'PETUNJUK PENGISIAN'
                );


                $sheet->setCellValue(
                    'A6',
                    'Status hanya boleh Parent atau Child. Jika Parent maka Atasan dikosongkan.'
                );





                /*
                |--------------------------------------------------------------------------
                | STYLE JUDUL
                |--------------------------------------------------------------------------
                */


                $sheet->getStyle('A1:A3')
                ->applyFromArray([


                    'font'=>[

                        'bold'=>true,

                        'size'=>14,

                    ],


                    'alignment'=>[

                        'horizontal'=>Alignment::HORIZONTAL_CENTER

                    ]

                ]);




                $sheet->getStyle('A5:A6')
                ->applyFromArray([


                    'font'=>[

                        'bold'=>true,

                    ]


                ]);






                /*
                |--------------------------------------------------------------------------
                | WARNA INPUT WAJIB
                |--------------------------------------------------------------------------
                |
                | User diarahkan mengisi kolom ini
                |
                */


                $sheet->getStyle('A8:D107')
                ->applyFromArray([


                    'fill'=>[

                        'fillType'=>Fill::FILL_SOLID,

                        'startColor'=>[

                            'rgb'=>'FFF2CC'

                        ]

                    ]


                ]);







                /*
                |--------------------------------------------------------------------------
                | MEMBUAT SHEET MASTER
                |--------------------------------------------------------------------------
                |
                | Sheet ini sumber dropdown
                | kemudian disembunyikan
                |
                */


                $master = new Worksheet(
                    $spreadsheet,
                    'MASTER'
                );


                $spreadsheet->addSheet($master);





                /*
                |--------------------------------------------------------------------------
                | DATA STATUS
                |--------------------------------------------------------------------------
                */


                $master->setCellValue(
                    'A1',
                    'STATUS'
                );


                $master->setCellValue(
                    'A2',
                    'Parent'
                );


                $master->setCellValue(
                    'A3',
                    'Child'
                );







                /*
                |--------------------------------------------------------------------------
                | DATA ATASAN
                |--------------------------------------------------------------------------
                */


                $master->setCellValue(
                    'C1',
                    'ATASAN'
                );


                $master->setCellValue(
                    'C2',
                    '-'
                );



                $leaders = OrganizationStructure::orderBy(
                    'full_name'
                )
                ->pluck('full_name');



                $rowLeader = 3;



                foreach($leaders as $leader){


                    $master->setCellValue(
                        "C{$rowLeader}",
                        $leader
                    );


                    $rowLeader++;


                }






                /*
                |--------------------------------------------------------------------------
                | STYLE MASTER
                |--------------------------------------------------------------------------
                */


                $master->getStyle('A1:C1')
                ->getFont()
                ->setBold(true);





                /*
                |--------------------------------------------------------------------------
                | SEMBUNYIKAN MASTER
                |--------------------------------------------------------------------------
                */


                $master->setSheetState(
                    Worksheet::SHEETSTATE_HIDDEN
                );







                /*
                |--------------------------------------------------------------------------
                | DROPDOWN EXCEL
                |--------------------------------------------------------------------------
                */


                for(
                    $i = 8;
                    $i <= 107;
                    $i++
                ){



                    /*
                    |--------------------------------------------------------------------------
                    | STATUS
                    |--------------------------------------------------------------------------
                    */


                    $status = $sheet
                        ->getCell("C{$i}")
                        ->getDataValidation();



                    $status->setType(
                        DataValidation::TYPE_LIST
                    );


                    $status->setErrorStyle(
                        DataValidation::STYLE_STOP
                    );


                    $status->setAllowBlank(true);


                    $status->setShowDropDown(true);


                    $status->setFormula1(
                        "=MASTER!\$A\$2:\$A\$3"
                    );








                    /*
                    |--------------------------------------------------------------------------
                    | ATASAN
                    |--------------------------------------------------------------------------
                    */


                    $leader = $sheet
                        ->getCell("D{$i}")
                        ->getDataValidation();



                    $leader->setType(
                        DataValidation::TYPE_LIST
                    );



                    $leader->setErrorStyle(
                        DataValidation::STYLE_STOP
                    );



                    $leader->setAllowBlank(true);



                    $leader->setShowDropDown(true);



                    $leader->setFormula1(
                        "=MASTER!\$C\$2:\$C\$"
                        .($rowLeader-1)
                    );



                }






                /*
                |--------------------------------------------------------------------------
                | FREEZE HEADER
                |--------------------------------------------------------------------------
                */


                $sheet->freezePane(
                    'A8'
                );




            }


        ];

    }


    
}
