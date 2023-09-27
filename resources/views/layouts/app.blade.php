<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

{{-- Inicia lo de admiria --}}

            <!-- App favicon -->
            <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

            <!-- Fonts -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

            <!-- Bootstrap Css -->



            <!-- Icons Css -->
            <link href="/admiria/assets/css/icons.min.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

            <!-- App Css-->
            <link href="/admiria/assets/css/app.min.css" rel="stylesheet" type="text/css">
            <!-- Custom Css-->
            <link href="/admiria/assets/css/custom.css" rel="stylesheet" type="text/css">
            <link href="/admiria/assets/css/font.css" rel="stylesheet" type="text/css">

            <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


{{-- Termina lo de Admiria --}}
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        {{-- Inicia Admiria --}}
        @include('layouts.home.javascript_files')
        @yield('scripts')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            window.addEventListener('alert', ({
                detail: {
                    type,
                    message
                }
            }) => {
                Toast.fire({
                    icon: type,
                    title: message
                })
            })


            // Confirmar Eliminación
            function confirm_modal(id) {
                var record = id;
                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: "{{ __('You will not be able to revert this!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Yes, delete it!') }}",
                    cancelButtonText: "{{ __('Cancel') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit('destroy', record);
                        Swal.fire(
                            "{{ __('Deleted!') }}",
                            "{{ __('Your record has been deleted.') }}",
                            'success'
                        )
                    }
                })
            }



            //  Confirmar Grabar Datos Complementarios
            function confirm_user_data() {
                Swal.fire({
                    title: "¿Está Seguro?",
                    text: "Al aceptarlo no podrá realizar cambios a menos que se comunique con un administrador. Los datos se validarán y si son correctos se grabarán",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "SI, Continuar",
                    cancelButtonText: "{{ __('Cancel') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit('store_data');
                        Swal.fire(
                            "¡Listo!",
                            "Actualizando Datos",
                            'warning'
                        )
                    }
                })
            }

        </script>
        {{-- Finaliza Admiria --}}
    </body>
</html>
