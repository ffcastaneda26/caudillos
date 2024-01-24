<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        @media (max-width: 640px) {
            .text-custom {
                font-size: 12px;
            }

            .images-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body class="fondo-principal">
    <container-fluid>
        <div class="my-auto mt-5 max-w-7xl mx-auto">

            @include('welcome_register_login_buttons')

            <header>
                <div class="welcome-legend texto-azul flex flex-col items-center font-extrabold">
                    <p>Con tu aportación estás apoyando al </p>
                    <p>"Programa Formación en Deportes y Valores</p>
                    <p>Torneo Tochito Estatal 2023-2024"</p>
                </div>
            </header>

            <div class="sm:bg-dark images-row">
                <img class="image" src="{{ asset('images/patrocinios/tdxcausa.png') }} "alt="TDxCausa">
                <img class="image" src="{{ asset('images/patrocinios/fundacion_caudillos.png') }} "alt="Fundación Caudillos">
                <img class="image" src="{{ asset('images/patrocinios/jidosha_vertical.png') }}" alt="Jidosha">
                {{-- <img class="image" src="{{ asset('images/patrocinios/secorp.png') }}" alt="Secorp"> --}}

            </div>

            <div class="welcome-legend-second texto-azul font-semibold">
                Trabajando en conjunto en busca de un mejor Chihuahua
            </div>

            <div class="text-link-information flex flex-row justify-center items-center mb-4 link_mas_informacion texto-oro underline">
                <a href=""> Mas información del proyecto </a>
            </div>
        </div>


    </container-fluid>

</body>

</html>
