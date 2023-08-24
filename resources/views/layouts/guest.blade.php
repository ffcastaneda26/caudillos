<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>


            <!-- App favicon -->
            <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="/admiria/assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        <!-- App Css-->
        <link href="/admiria/assets/css/app.min.css" rel="stylesheet" type="text/css">
        <!-- Custom Css-->
        <link href="/admiria/assets/css/custom.css" rel="stylesheet" type="text/css">
        <link href="/admiria/assets/css/font.css" rel="stylesheet" type="text/css">

        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- <script src="https://www.google.com/recaptcha/api.js?render=6LeMws4nAAAAANplVRimJKeXbC4snnd4R-Es262a"></script>
        <script>
            document.addeventlistener('submit',function(e){
                e.preventDefault();
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LeMws4nAAAAANplVRimJKeXbC4snnd4R-Es262a', {action: 'submit'}).then(function(token) {
                        let form = e.target;
                        let input = document.createElement('input');
                        // input.type = 'hidden';
                        input.name = 'g-regcaptcha-response';
                        input.value = token;
                        form.appendChild(input);
                        form.submit();
                    });
                });
            });
        </script> --}}


    </head>
    <body>
        <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
