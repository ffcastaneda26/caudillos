<x-app-layout>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="container-fluid mt-2">
                @if(Auth::user()->has_suplementary_data())
                    <div class="card container">
                        <div class="py-4 flex justify-center">
                            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                            ¿Cómo participar en TDxCausa 2024?
                            </h1>

                        </div>
                        <div class="py-4 flex justify-center">
                            <div class="ul text-left">
                                <li> En la sección "Pronósticos" Cada Participante debe ingresar su predicción de puntos al partido
                                    tanto para Local como para Visita.</li>
                                <li>Los partidos de “Caudillos” o el último partido de la Jornada en la fecha que Caudillos descanse, se
                                    considerarán como Partido de Desempate (-PD-).</li>
                                <li>Al momento de cambiar cualquier marcador, el sistema guarda automáticamente ese dato como la
                                    predicción, es importante verificar sus predicciones antes de cerrar sesión.</li>
                                <li>Cada pronóstico puede ser modificado hasta 5 minutos antes de la hora de inicio del partido, pasado
                                    este tiempo límite se deshabilita la caja para ingresar marcador.</li>
                                <li>Los partidos que estén deshabilitados para predecir, automáticamente se hacen visibles para todos
                                    los participantes en "Tabla de Pronosticos".</li>
                            </div>
                        </div>
                    </div>
                @else
                    @include('welcome')
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
