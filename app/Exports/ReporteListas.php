<?php

namespace App\Exports;

use App\Models\Lista; // Asegúrate de incluir el modelo correspondiente
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReporteListas implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $listas;
    protected $filtros;
    protected $cabecera;
    protected $seccionTabla;
    protected $fechaReporte;

    public function __construct($listas, $filtros, $fechaReporte)
    {
        $this->fechaReporte = $fechaReporte;
        $this->listas = $listas;
        $this->filtros = $filtros;
        $this->cabecera = ['Lista de Empaque','OC/Factura','Proveedor','Fecha Recepción','Cantidad de Empaques','Ingreso','Egreso','Saldo'];
        $this->seccionTabla = [];

    }

    public function collection()
    {
        $data[] = ['','REPORTE DETALLE DE LISTA DE EMPAQUE'];
        $data[] = [''];
        $data[] = ['','','','','','','Fecha reporte:',$this->fechaReporte];
        $data[] = [''];
        $data[] = ['Fecha de recepción:','Del '.$this->filtros['fechaInicio'].' al '.$this->filtros['fechaFin'],'','Proveedor:',$this->filtros['proveedorSeleccionado']];        
        $data[] = [''];
        $data[] = $this->cabecera;
        $pos = 7;
        $seccion = array();
        $seccion[0]=$pos;
        if ($this->listas->isNotEmpty()) {
            foreach ($this->listas as $lista) {
                $pos++;
                $data[] = [
                    $lista->codigo,
                    $lista->factura,
                    $lista->proveedor_nombre,
                    Carbon::parse($lista->fecha_recepcion)->format('d-m-Y'),
                    $lista->stock_esperado,
                    $lista->stock_registrado,
                    ($lista->stock_registrado - $lista->stock_actual),
                    $lista->stock_actual
                ];     
            }
    
            $seccion[1] = $pos; // Finaliza la posición de la tabla
            $this->seccionTabla[] = $seccion;
            /*
            
            $data[] = [
                '',
                '',
                '',
                'Total', // Celda D: Texto "Total"
                '=SUM(E8:E' . $pos . ')', // Celda E: Suma de Cantidad de Empaques
                '=SUM(F8:F' . $pos . ')', // Celda F: Suma de Ingresos
                '=SUM(G8:G' . $pos . ')', // Celda G: Suma de Egresos
                '=SUM(H8:H' . $pos . ')'  // Celda H: Suma de Saldos
            ];
            */
        } else {
            // Si no hay filas, puedes agregar una fila vacía o un mensaje
            $data[] = [
                'Sin resultados'
            ];
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
           
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('B1:H1')->getFont()->setBold(true);

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->mergeCells('B1:G1');
        // Establecer el estilo del texto en las celdas fusionadas
        $sheet->getStyle('B1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1:G1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


        $sheet->getStyle('G3')->getFont()->setBold(true);
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('D5')->getFont()->setBold(true);

         // Estilo para la fila de totales
        if( $this->listas->isNotEmpty()){
            $sheet->getStyle('D' . ($this->seccionTabla[0][1] + 1).':H'.($this->seccionTabla[0][1] + 1))->getFont()->setBold(true); // Total

            $sheet->getStyle('D' . ($this->seccionTabla[0][1] + 1).':H'.($this->seccionTabla[0][1] + 1))->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);
        }ELSE{
            $sheet->mergeCells('A8:H8');
            $sheet->getStyle('A8:H8')->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);
            $sheet->getStyle('A8:H8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        }
            

         $sheet->getStyle('A7:H7')->getFont()->setBold(true);
         $sheet->getStyle('A7:H7')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

         foreach ($this->seccionTabla as $seccion) {

             $rangoContenido = 'A' . $seccion[0] . ':A' . $seccion[1];
             $sheet->getStyle($rangoContenido)->applyFromArray([
                 'borders' => [
                     'allBorders' => [
                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => ['argb' => '000000'],
                     ],
                 ],
             ]);
             $rangoContenido = 'B' . $seccion[0] . ':B' . $seccion[1];
             $sheet->getStyle($rangoContenido)->applyFromArray([
                 'borders' => [
                     'allBorders' => [
                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => ['argb' => '000000'],
                     ],
                 ],
             ]);
             $rangoContenido = 'C' . $seccion[0] . ':C' . $seccion[1];
             $sheet->getStyle($rangoContenido)->applyFromArray([
                 'borders' => [
                     'allBorders' => [
                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => ['argb' => '000000'],
                     ],
                 ],
             ]);
             $rangoContenido = 'D' . $seccion[0] . ':D' . $seccion[1];
             $sheet->getStyle($rangoContenido)->applyFromArray([
                 'borders' => [
                     'allBorders' => [
                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => ['argb' => '000000'],
                     ],
                 ],
             ]);
             $rangoContenido = 'E' . $seccion[0] . ':E' . $seccion[1];
             $sheet->getStyle($rangoContenido)->applyFromArray([
                 'borders' => [
                     'allBorders' => [
                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => ['argb' => '000000'],
                     ],
                 ],
             ]);
             $rangoContenido = 'F' . $seccion[0] . ':F' . $seccion[1];
             $sheet->getStyle($rangoContenido)->applyFromArray([
                 'borders' => [
                     'allBorders' => [
                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => ['argb' => '000000'],
                     ],
                 ],
             ]);
             $rangoContenido = 'G' . $seccion[0] . ':G' . $seccion[1];
             $sheet->getStyle($rangoContenido)->applyFromArray([
                 'borders' => [
                     'allBorders' => [
                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => ['argb' => '000000'],
                     ],
                 ],
             ]);
             $rangoContenido = 'H' . $seccion[0] . ':H' . $seccion[1];
             $sheet->getStyle($rangoContenido)->applyFromArray([
                 'borders' => [
                     'allBorders' => [
                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => ['argb' => '000000'],
                     ],
                 ],
             ]);

         }
        //$sheet->getColumnDimension('A')->setWidth(15);
        //$sheet->getRowDimension(1)->setRowHeight(15);
        return [
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Agregar logo
                /*
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo de la empresa');
                $drawing->setPath(public_path('argon/img/brand/favicon.png')); // Cambia esta ruta a tu logo
                $drawing->setHeight(80); // Ajusta la altura según sea necesario
                $drawing->setCoordinates('A1'); // Establece la posición de la imagen en A1
                $drawing->setWorksheet($sheet);
*/
               
            },
        ];
    }

    
}
