<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            position: relative;
            font-family: Arial, sans-serif;
        }
        .image-container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative; /* Necessary for absolute positioning of text */
        }
        .image-container img {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
            object-fit: cover; /* Cover the entire page */
        }
        .posicion_nombre {
            position: absolute;
            top: 310px; /* Adjust this value to move text vertically */
            left: 80%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Center the content */
            color: black; /* Change color to black */
            font-size: 10px; /* Adjust font size as needed */
            text-shadow: none; /* Remove text shadow */
            text-transform: uppercase; /* Convert text to uppercase */
            white-space: nowrap; /* Prevent text from wrapping */
            width: 100%; /* Set width to control text overflow */
            overflow: hidden; /* Hide any overflow */
            text-overflow: ellipsis; /* Optional: Add ellipsis if text is too long */
        }
        .posicion_fecha {
            position: absolute;
            top: 360px; /* Adjust this value to move text vertically */
            left: 80%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Center the content */
            color: black; /* Change color to black */
            font-size: 10px; /* Adjust font size as needed */
            text-shadow: none; /* Remove text shadow */
            text-transform: uppercase; /* Convert text to uppercase */
            white-space: nowrap; /* Prevent text from wrapping */
            width: 100%; /* Set width to control text overflow */
            overflow: hidden; /* Hide any overflow */
            text-overflow: ellipsis; /* Optional: Add ellipsis if text is too long */
        }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="./argon/img/certificados_diente/certificado_niña.jpg" alt="Certificado">
        <div class="posicion_nombre">
            <h1>{{ $nombre }}</h1>
        </div>
        <div class="posicion_fecha">
            <h1>{{ $fecha }}</h1>
        </div>
    </div>
</body>
</html>
