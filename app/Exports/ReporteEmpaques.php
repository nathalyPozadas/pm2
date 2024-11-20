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

class ReporteEmpaques implements FromCollection, WithHeadings, WithStyles, WithEvents
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
        $this->cabecera = ['Lista de Empaque','N° Empaque','Empaque','Detalle','Peso','U.M.','Ubicación Anterior','Ubicación Actual'];
        $this->seccionTabla = [];

    }

    public function collection()
    {
        $data[] = ['','REPORTE DETALLE TOTAL DE EMPAQUES POR LISTA DE EMPAQUE'];
        $data[] = [''];
        $data[] = ['','','','','','','Fecha reporte:',$this->fechaReporte];
        $data[] = [''];
        $data[] = ['Fecha de recepción:','Del '.$this->filtros['fechaInicio'].' al '.$this->filtros['fechaFin'] ,'','Proveedor:',$this->filtros['proveedorSeleccionado'],'','Almacen:',$this->filtros['almacenSeleccionado']];        
        $data[] = [''];
        $pos = 6;
        
        foreach ($this->listas as $lista) {
            $pos = $pos+2;
            $seccion = array();
            $seccion[0]=$pos;
            $data[] = ['Lista de Empaque',$lista->codigo,'','Stock Actual',$lista->stock_actual,'','Fecha Recepción:',Carbon::parse($lista->fecha_recepcion)->format('d-m-Y')];
            $data[] = $this->cabecera;
            foreach ($lista->contenido as $empaque) {
                $pos++;
                $data[] = [
                        $empaque->lista_empaque_codigo,
                        $empaque->numero,
                        $empaque->tipo,
                        $empaque->descripcion,
                        $empaque->peso,
                        $empaque->unidad_medida,
                        $empaque->ub_anterior,
                        $empaque->empaque_almacen.' > '.$empaque->empaque_ubicacion
                    ];
            }
            $seccion[1]=$pos;
            $this->seccionTabla[] = $seccion;
            $data[] = [''];
            $pos++;
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
        $sheet->getStyle('G5')->getFont()->setBold(true);
        // Aplicar bordes solo en los rangos definidos en seccionTabla
        foreach ($this->seccionTabla as $seccion) {
            $rangoContenido = 'A' . $seccion[0] . ':H' . $seccion[1];
            $sheet->getStyle($rangoContenido)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);
        
            $primeraFila = 'A' . $seccion[0] . ':H' . $seccion[0];
            $sheet->getStyle($primeraFila)->getFont()->setBold(true);
            $sheet->getStyle('A'.($seccion[0]-1))->getFont()->setBold(true);
            $sheet->getStyle('D'.($seccion[0]-1))->getFont()->setBold(true);
            $sheet->getStyle('G'.($seccion[0]-1))->getFont()->setBold(true);
        }
        /*
        foreach ($this->seccionTabla as $seccion) {
            for ($row = $seccion[0]; $row <= $seccion[1]; $row++) {
                $sheet->getRowDimension($row)->setOutlineLevel(1); 
                $sheet->getRowDimension($row)->setVisible(true);
            }
        }*/
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getRowDimension(1)->setRowHeight(15);
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
