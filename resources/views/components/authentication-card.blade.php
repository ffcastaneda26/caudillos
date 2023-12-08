<div class="fondo-principal min-h-screen flex flex-col justify-start sm:justify-center items-center pt-6 sm:pt-0  dark:bg-gray-900">
    <div>
        {{ $logo }}
    </div>

    <div class="mt-4 sm:max-w-md p-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>

</div>
