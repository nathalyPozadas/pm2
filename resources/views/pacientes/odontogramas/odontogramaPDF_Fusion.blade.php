<!DOCTYPE html>
<html lang="es">
<head>
    
    <title>Odontograma</title>
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
<div style = "text-align: right;">
    <h5>{{$odontogramas_seleccionados[0]['fecha_actual']}}</h5>
</div>
<br>
    <h3>Paciente: {{$odontogramas_seleccionados[0]['paciente']->apellidos.' '.$odontogramas_seleccionados[0]['paciente']->nombres}}</h3>
@foreach($odontogramas_seleccionados as $odontograma_seleccionado)
        @if($odontograma_seleccionado['odontograma_estado']== 'INICIO REVISION')
            <div >
                    
                    <div class="titulo ">
                        <h2>Odontograma #{{$odontograma_seleccionado['odontograma_id']}} </h2> 
                        <div class="estado-fase1">{{$odontograma_seleccionado['odontograma_estado']}}</div>
                    </div>
                </div>
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
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                            <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </td>
                        @endfor

                        @php
                        $start = 21;
                        $end = 28;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                            <td>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                                <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </td>
                        @endfor
                    </tr>
                    
                    </table>
                    <table class="bordes-transparentes">
                    <tr>
                        @php
                        $start = 55;
                        $end = 51;
                        @endphp
                        @for ($i = $start; $i >= $end; $i--)
                        <th> {{$i}}</th>
                        @endfor
                        @php
                        $start = 61;
                        $end = 65;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                        <th> {{$i}}</th>
                        @endfor
                    </tr>
                    <tr>
                        @php
                        $start = 55;
                        $end = 51;
                        @endphp
                        @for ($i = $start; $i >= $end; $i--)
                        <td>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                            <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </td>
                        @endfor

                        @php
                        $start = 61;
                        $end = 65;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                            <td>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                                <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </td>
                        @endfor
                    </tr>
                    
                    </table>

                    <table class="bordes-transparentes">
                    <tr>
                    @php
                        $start = 85;
                        $end = 81;
                        @endphp
                        @for ($i = $start; $i >= $end; $i--)
                        <th>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                            <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </th>
                        @endfor

                        @php
                        $start = 71;
                        $end = 75;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                            <th>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                                <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </th>
                        @endfor
                    </tr>
                    <tr>
                    @php
                        $start = 85;
                        $end = 81;
                        @endphp
                        @for ($i = $start; $i >= $end; $i--)
                        <td> {{$i}}</td>
                        @endfor
                        @php
                        $start = 71;
                        $end = 75;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                        <td> {{$i}}</td>
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
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                            <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </th>
                        @endfor

                        @php
                        $start = 31;
                        $end = 38;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                            <th>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                                <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
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
                <h3>RESUMEN</h3>
                <div>
                    <div class="container">
                        <table class="minimalistBlack">
                            <thead>
                            <tr>
                                <th>PIEZA</th>
                                <th>DIAGNOSTICO</th>
                                <th>TRATAMIENTO</th>
                                <th>PRECIO</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($odontograma_seleccionado['detalles'] as $detalle)
                                <tr>
                                    <td style="text-align: center">{{$detalle->diente_pieza}}</td>
                                    <td style="text-align: center">{{$detalle->situacion_nombre}}</td>
                                    <td style="text-align: center">{{$detalle->tratamiento_nombre}}</td>
                                    <td style="text-align: center">{{$detalle->tratamiento_aplicado_precio}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    
                </div>
        @else
                        <div >
                    
                    <div class="titulo ">
                        <h2>Odontograma #{{$odontograma_seleccionado['odontograma_id']}} </h2> 
                    @if($odontograma_seleccionado['odontograma_estado'] == 'REVISION FINALIZADA')
                        <div class="estado-fase2">{{$odontograma_seleccionado['odontograma_estado']}}</div>
                    @else
                        <div class="estado-fase3">{{$odontograma_seleccionado['odontograma_estado']}}</div>
                    @endif
                    </div>
                </div>
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
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                            <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </td>
                        @endfor

                        @php
                        $start = 21;
                        $end = 28;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                            <td>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                                <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </td>
                        @endfor
                    </tr>
                    
                    </table>
                    <table class="bordes-transparentes">
                    <tr>
                        @php
                        $start = 55;
                        $end = 51;
                        @endphp
                        @for ($i = $start; $i >= $end; $i--)
                        <th> {{$i}}</th>
                        @endfor
                        @php
                        $start = 61;
                        $end = 65;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                        <th> {{$i}}</th>
                        @endfor
                    </tr>
                    <tr>
                        @php
                        $start = 55;
                        $end = 51;
                        @endphp
                        @for ($i = $start; $i >= $end; $i--)
                        <td>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                            <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </td>
                        @endfor

                        @php
                        $start = 61;
                        $end = 65;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                            <td>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                                <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </td>
                        @endfor
                    </tr>
                    
                    </table>

                    <table class="bordes-transparentes">
                    <tr>
                    @php
                        $start = 85;
                        $end = 81;
                        @endphp
                        @for ($i = $start; $i >= $end; $i--)
                        <th>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                            <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </th>
                        @endfor

                        @php
                        $start = 71;
                        $end = 75;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                            <th>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                                <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </th>
                        @endfor
                    </tr>
                    <tr>
                    @php
                        $start = 85;
                        $end = 81;
                        @endphp
                        @for ($i = $start; $i >= $end; $i--)
                        <td> {{$i}}</td>
                        @endfor
                        @php
                        $start = 71;
                        $end = 75;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                        <td> {{$i}}</td>
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
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                            <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
                            </th>
                        @endfor

                        @php
                        $start = 31;
                        $end = 38;
                        @endphp
                        @for ($i = $start; $i <= $end; $i++) 
                            <th>
                            @if(isset($odontograma_seleccionado['imagenes'][$i]))
                            <img  src="data:image/png;base64,{{$odontograma_seleccionado['imagenes'][$i]}}" style="height:35px; width:35px;">
                            @else
                                <img src="./argon/img/iconos-odontograma/diente-base.svg" style="height:35px; width:35px;">
                            @endif
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
                <h3>RESUMEN</h3>
                <div>
                    <div class="container">
                        <table class="minimalistBlack">
                            <thead>
                            <tr>
                                <th>PIEZA</th>
                                <th>DIAGNOSTICO</th>
                                <th>TRATAMIENTO</th>
                                <th>PRECIO</th>
                                <th>ESTADO</th>
                                <th>A CUENTA</th>
                                <th>SALDO</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($odontograma_seleccionado['detalles'] as $detalle)
                                <tr>
                                    <td style="text-align: center">{{$detalle->diente_pieza}}</td>
                                    <td style="text-align: center">{{$detalle->situacion_nombre}}</td>
                                    <td style="text-align: center">{{$detalle->tratamiento_nombre}}</td>
                                    <td style="text-align: center">{{$detalle->tratamiento_aplicado_precio}}</td>
                                    <td style="text-align: center">{{$detalle->tratamiento_aplicado_estado}}</td>
                                    <td style="text-align: center">{{$detalle->tratamiento_aplicado_pago_realizado}}</td>
                                    <td style="text-align: center">
                                        @if($detalle->tratamiento_aplicado_precio !== '-')
                                            {{$detalle->tratamiento_aplicado_precio-$detalle->tratamiento_aplicado_pago_realizado}}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <BR>
                    <h3>DETALLE TRABAJO</h3>
                    @foreach($odontograma_seleccionado['detalles'] as $detalle)
                    <h4>Pieza#{{$detalle->diente_pieza}}-{{$detalle->situacion_nombre}}-{{$detalle->tratamiento_nombre}}</h4>
                        <div>
                            @if(count($detalle->acciones)>0)
                                <table class="minimalistBlack">
                                    <thead>
                                    <tr>
                                        <th>FECHA</th>
                                        <th>TRABAJO REALIZADO</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($detalle->acciones as $accion)
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
                    <BR>
                    <h3>DETALLE PAGOS</h3>
                    <h4>Pieza#{{$detalle->diente_pieza}}-{{$detalle->situacion_nombre}}-{{$detalle->tratamiento_nombre}}</h4>
                        <div>
                            @if(count($detalle->pagos)>0)
                                <table class="minimalistBlack">
                                    <thead>
                                    <tr>
                                        <th>FECHA</th>
                                        <th>MONTO (Bs.)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($detalle->pagos as $pago)
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
                    @endforeach
                </div>
        @endif
@endforeach
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
