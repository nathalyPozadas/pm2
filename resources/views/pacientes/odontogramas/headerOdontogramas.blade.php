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
    {{$body}}
    
</body>

</html>