<!DOCTYPE html>
<html lang="es">
<head>
    
    <title>Implante#{{$implante->id}}</title>
    <style>
        body{
            font-family: "Helvetica";
        }
        .centrar-tablas {
        text-align: center;
        margin: 0 auto; 
        
        }
        .centrar-tablas table {
        margin: 0 auto; 
        border-collapse: collapse;
        border-spacing: 0;
        width: 50%; 
        }
        .bordes-transparentes table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%; 
            background-color: #f9f9f9;
        }

        .bordes-transparentes th, .bordes-transparentes td {
            border: none;
            padding: 3px;
            text-align: center;
            width: calc(100% / 16); 
            background-color: #f9f9f9;
            color: #000000;
            font-weight: 400; 
        }
        table.minimalistBlack {
            border: 0px solid #000000;
            width: 100%;
            border-collapse: collapse;
        }
        table.minimalistBlack td, table.minimalistBlack th {
            border: 1px solid #000000;
            padding: 5px 4px;
        }
        table.minimalistBlack tbody td {
            font-size: 13px;
        }
        table.minimalistBlack thead {
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 0px solid #000000;
        }
        table.minimalistBlack thead th {
            font-size: 15px;
            font-weight: bold;
            color: #000000;
            text-align: center;
        }
        .container {
            position: relative;
            text-align: center;
            color: black;
        }

        .titulo {
            text-align: center;
            
        }
        .centered {
            position: absolute;
            top: 4%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .estado-fase1 {
            text-align: center;
            background-color: #a2cf6e;
            border-radius: 10px; 
            padding: 5px;
            margin-left:30%;
            margin-right:30%;
        }
       
        

    </style>
</head>
<body>
<div >
    <div style = "text-align: right;">
        <h5>{{$fecha_actual}}</h5>
    </div>
    <div class="titulo ">
        <h2>Implante#{{$implante->id}}</h2> 
    </div>
</div>
<br>
<h3>Paciente: {{$paciente->apellidos.' '.$paciente->nombres}}</h3>
<br>
<div class="centrar-tablas">
    <table class="bordes-transparentes">
    <tr>
        @php
        $start = 18;
        $end = 11;
        @endphp
        @for ($i = $start; $i >= $end; $i--)
        <th> {{$i}}</th>
        @endfor
        @php
        $start = 21;
        $end = 28;
        @endphp
        @for ($i = $start; $i <= $end; $i++) 
        <th> {{$i}}</th>
        @endfor
    </tr>
    <tr>
        @php
        $start = 18;
        $end = 11;
        @endphp
        @for ($i = $start; $i >= $end; $i--)
            <td>
                <img src="./argon/img/iconos-implantes/{{$i}}A.png" style="height:50px; width:35px;">
            </td>
        @endfor

        @php
        $start = 21;
        $end = 28;
        @endphp
        @for ($i = $start; $i <= $end; $i++) 
            <td>
                <img src="./argon/img/iconos-implantes/{{$i}}A.png" style="height:50px; width:35px;">
            </td>
        @endfor
    </tr>
    
    </table>
    
    <table class="bordes-transparentes">
    <tr>
    @php
        $start = 48;
        $end = 41;
        @endphp
        @for ($i = $start; $i >= $end; $i--)
            <th>
                <img src="./argon/img/iconos-implantes/{{$i}}A.png" style="height:50px; width:35px;">
            </th>
        @endfor

        @php
        $start = 31;
        $end = 38;
        @endphp
        @for ($i = $start; $i <= $end; $i++) 
            <th>
                <img src="./argon/img/iconos-implantes/{{$i}}A.png" style="height:50px; width:35px;">
            </th>
        @endfor
    </tr>
    <tr>
    @php
        $start = 48;
        $end = 41;
        @endphp
        @for ($i = $start; $i >= $end; $i--)
        <td> {{$i}}</td>
        @endfor
        @php
        $start = 31;
        $end = 38;
        @endphp
        @for ($i = $start; $i <= $end; $i++) 
        <td> {{$i}}</td>
        @endfor
        
    </tr>
    
    </table>
</div>
    <br>
    <h3>RESUMEN IMPLANTE #{{$implante->id}}</h3>
    <div>
        <div class="container">
            <table class="minimalistBlack">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>PIEZA</th>
                    <th>FECHA</th>
                    <th>IMPLANTE</th>
                    <th>MARCA</th>
                    <th>MEDIDA</th>
                    <th>COSTO</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center">{{$implante->id}}</td>
                        <td style="text-align: center">{{$implante->pieza}}</td>
                        <td style="text-align: center">{{$implante->fecha}}</td>
                        <td style="text-align: center">{{$tornillo->nombre}}</td>
                        <td style="text-align: center">{{$implante->marca}}</td>
                        <td style="text-align: center">{{$implante->medida}}</td>
                        <td style="text-align: center">{{$implante->costo}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <BR>
        <h3>DETALLE TRABAJO</h3>
        <h4>Implante#{{$implante->id}}</h4>
            <div>
                @if(count($acciones)>0)
                    <table class="minimalistBlack">
                        <thead>
                        <tr>
                            <th>FECHA</th>
                            <th>TRABAJO REALIZADO</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($acciones as $accion)
                                <tr>
                                    <td style="text-align: center">{{$accion->fecha}}</td>
                                    <td style="text-align: center">{{$accion->accion}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    Sin iniciar
                @endif
            </div>      
    </div>
<BR>
    <h3>DETALLE PAGOS</h3>
    <h4>Implante#{{$implante->id}}</h4>
        <div>
            @if(count($pagos)>0)
                <table class="minimalistBlack">
                    <thead>
                    <tr>
                        <th>FECHA</th>
                        <th>MONTO (Bs.)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pagos as $pago)
                        <tr>
                            <td style="text-align: center">{{$pago->fecha}}</td>
                            <td style="text-align: center">{{$pago->monto_pagado}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                No se han realizado pagos
            @endif
        </div>
<script type="text/php">
    if (isset($pdf)) {
        $pdf->page_script('
            $text = sprintf(_("Página %d de %d"),  $PAGE_NUM, $PAGE_COUNT);
            // Uncomment the following line if you use a Laravel-based i18n
            //$text = __("Página :pageNum de :pageCount", ["pageNum" => $PAGE_NUM, "pageCount" => $PAGE_COUNT]);
            $font = null;
            $size = 9;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default

            // Compute text width to center correctly
            $textWidth = $fontMetrics->getTextWidth($text, $font, $size);

            $x = ($pdf->get_width() - $textWidth) / 2;
            $y = $pdf->get_height() - 35;

            $pdf->text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        '); // End of page_script
    }
</script>
</body>
</html>
