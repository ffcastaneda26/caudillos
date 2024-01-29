<?php

use App\Models\User;
use App\Http\Livewire\Games;
use App\Http\Livewire\Picks;
use App\Http\Livewire\Teams;
use App\Http\Livewire\Users;
use App\Http\Livewire\Rounds;
use App\Models\Configuration;
use App\Http\Livewire\Results;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\DataUsers;
use App\Http\Livewire\Entidades;
use App\Http\Livewire\UsersData;
use App\Http\Livewire\Municipios;
use App\Http\Livewire\PicksReview;
use App\Http\Livewire\SelectRound;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Configurations;
use App\Http\Livewire\PicksRoundUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Livewire\Positions\ByRound;
use App\Http\Livewire\Positions\General;

Route::get('cambiar-password/{email}',function($email){
    $user = User::where('email',$email)->first();
    $user->password = bcrypt('password');
    $user->save();
    dd($user->password);

});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session')])->group(function () {

    Route::get('/dashboard', function () {
        $configuration_record = Configuration::first();
        return view('dashboard',compact('configuration_record'));
    })->name('dashboard');

    Route::get('games',Games::class)->name('games');                                // Juegos
    Route::get('picks',Picks::class)->name('picks');                                // Pronósticos
    Route::get('positions-by-round',ByRound::class)->name('positions-by-round');    // Posiciones x Jornada
    Route::get('positions-general',General::class)->name('positions-general');      // Posiciones General
    Route::get('results-by-round',Results::class)->name('results-by-round');        // Resultados x Jornada
    Route::get('data-users',DataUsers::class)->name('data-users');                  // Datos complementarios
    Route::get('rounds',Rounds::class)->name('rounds');                             // Jornadas

   Route::get('/suscribe/{sesion_id}',function($sesion_id){                         // Registrar el pago
        if (Auth::check() && $sesion_id) {
            $user= Auth::user();
            $user->stripe_session = $sesion_id;
            $user->paid = 1;
            $user->save();
        }
        return redirect()->route('dashboard');
    });

});



Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');



Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'role:Admin'])->group(function () {
    Route::get('configurations',Configurations::class)->name('configurations'); // Configuración General
    Route::get('entidades',Entidades::class)->name('entidades');        // Entidades Federativas
    Route::get('municipios',Municipios::class)->name('municipios');     // municipios Federativas
    Route::get('teams',Teams::class)->name('teams');                    // Equipos
    Route::get('rounds',Rounds::class)->name('rounds');                 // Jornadas
    Route::get('partidos',[GameController::class,'index'])->name('partidos');
    Route::get('users',Users::class)->name('users'); // Usuarios
});

Route::get('current_round',SelectRound::class);




