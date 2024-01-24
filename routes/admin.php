<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Livewire\CreateMissingPicks;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\RoundController;
// use App\Http\Controllers\Admin\ConfigurationController;

Route::get('create-missing-picks',CreateMissingPicks::class)->name('create-missing-picks');

Route::middleware(['auth','role:Admin'])->group(function () {
    Route::get('storage-link',function(){
        if(Auth::user()->hasRole('Admin')){
            if(file_exists(public_path('storage'))){
                return public_path('storage') . 'Ya existe...';
            }
            Artisan::call('storage:link');
            return 'Has creado tu enlace Simbolico';
        }else{
            return 'No autorizado para este comando';
        }
    });

    Route::get('optimize',function(){
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        return 'Se optimizó y se limpió el caché';
    });

});

Route::get('/',[HomeController::class,'index']);

// Route::resource('configurations', ConfigurationController::class);
Route::resource('teams', TeamController::class);
Route::resource('rounds', RoundController::class);
Route::resource('games', GameController::class);


