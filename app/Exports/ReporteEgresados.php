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

class ReporteEgresados implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $lista;
    protected $filtros;
    protected $cantEgresados;
    protected $detalleEgresados;
    protected $cabecera;
    protected $seccionTabla;
    protected $fechaReporte;

    public function __construct($lista, $filtros, $cantEgresados,$detalleEgresados,$fechaReporte)
    {
        $this->fechaReporte = $fechaReporte;
        $this->lista = $lista;
        $this->filtros = $filtros;
        $this->cantEgresados = $cantEgresados;
        $this->detalleEgresados = $detalleEgresados;
        $this->cabecera = ['Lista de Empaque','N° Empaque','Tipo','Descripción','Cant. Cajas','Peso','U.M.'];
        $this->seccionTabla = [];

    }

    public function collection()
    {
        $data[] = ['','REPORTE EGRESOS DE EMPAQUES'];
        $data[] = [''];
        $data[] = ['','','','','Fecha reporte:',$this->fechaReporte];
        $data[] = [''];
        $data[] = ['Fecha de recepción:','Del '.$this->filtros['fechaInicio'].' al '.$this->filtros['fechaFin'],'','Destino:',$this->filtros['destino']];        
        $data[] = [''];
        $data[] = $this->cabecera;
        $pos = 7;
        $seccion = array();
        $seccion[0]=$pos;
        if ($this->lista->isNotEmpty()) {
            foreach ($this->lista as $empaque) {
                $pos++;
                $data[] = [
                    $empaque->lista_empaque_codigo,
                    $empaque->numero,
                    $empaque->tipo,
                    $empaque->descripcion,
                    $empaque->cantidad_cajas,
                    $empaque->peso,
                    $empaque->unidad_medida
                ];     
            }
    
            $seccion[1] = $pos; // Finaliza la posición de la tabla
            $this->seccionTabla[] = $seccion;
            $data[] = ['']; 
            $data[] = ['Total Egresados', $this->cantEgresados]; 
            $data[] = ['']; 
            $data[] = ['Total Cant. Pallets',$this->detalleEgresados['cant_pallet']];   
            $data[] = ['Total Cant. Cajas',$this->detalleEgresados['cant_caja']];  
            $data[] = ['Total Cant. Bolsas',$this->detalleEgresados['cant_bolsa']];  
            $data[] = ['']; 
            foreach ($this->detalleEgresados['peso_por_unidad'] as $unidad => $pesoTotal) {
                if ($unidad !== '') {
                    $data[] = [$unidad, $pesoTotal??0];
                }
            }
            
            
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

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->mergeCells('B1:G1');
        // Establecer el estilo del texto en las celdas fusionadas
        $sheet->getStyle('B1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1:G1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


        $sheet->getStyle('E3')->getFont()->setBold(true);
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('D5')->getFont()->setBold(true);

        $sheet->getStyle('D')->getAlignment()->setWrapText(true);


         $sheet->getStyle('A7:G7')->getFont()->setBold(true);
         $sheet->getStyle('A7:G7')->applyFromArray([
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
