<?php

use App\Http\Livewire\CreateMissingPicks;
use App\Models\Game;
use App\Models\Pick;
use App\Models\User;
use App\Models\Round;
use App\Models\Entidad;
use App\Models\Profile;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Livewire\Traits\FuncionesGenerales;

Route::get('create-missing-picks',CreateMissingPicks::class)->name('create-missing-picks');

Route::get('generar_pronosticos_faltantes',function(){
    $rounds = Round::all();
    $users = User::role('participante')->whereDoesntHave('picks')->get();
 });



Route::get('pruebax',function(){
    // $funciones_generales = new FuncionesGenerales;
    $game = Game::find(4);
    $this->update_hit_last_game( $game);
    echo 'Revisa por favor...';
});

Route::get('/juegos_sin_pronostico_usuario_conectado',function(){
    $games = game::whereDoesntHave('picks', function (Builder $query) {
        $query->where('user_id',Auth::user()->id);
    })->get();
    dd($games);
});

Route::get('/usuarios_rol/{role}',function($role){

    $users = User::role($role)->get();
    dd($users);
});

Route::get('usuarios_sin_puntos_x_jornada/{round}',function($round){
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    $users = User::role('participante')->whereDoesntHave('positions',function($query) use ($round) {
        $query->where('round_id',$round);
    })->get();
    dd($users->count());

});

Route::get('sumar_aciertos/{round}',function(Round $round){


    $users = User::role('participante')
                ->select('users.id as user_id','rounds.id as round_id',DB::raw('SUM(picks.hit) as hits'))
                ->Join('picks', 'picks.user_id', '=', 'users.id')
                ->Join('games', 'picks.game_id', '=', 'games.id')
                ->Join('rounds', 'games.round_id', '=', 'rounds.id')
                ->where('games.round_id',$round->id)
                ->where('users.active','1')
                ->groupBy('users.id')
                ->groupBy('rounds.id')
                ->get();

    if(!empty($users)){
        foreach($users as $user){
            dd('user_id=' . $user->user_id. ' round_id=' . $user->round_id . ' Aciertos=' . $user->hits);
        }
    }


});

Route::get('posiciones',function(){
    $positions = Position::orderbyDesc('hits')
                         ->orderby('created_at')
                         ->get();
    echo '<table border="1">';
    echo '<tr><th>CORREO</th><th>ACIERTOS</th></tr>';

        foreach($positions as $position){
            echo '<tr>';
                echo '<td>' . $position->user->name . '</td>';
                echo '<td>' . $position->hits . '</td>';
            echo '</tr>';
        }

    echo '</table>';
});


Route::get('tabla-posiciones',function(){
    $positions = User::role('participante')
                        ->select('users.first_name',
                                'users.last_name',
                                DB::raw('SUM(positions.hits) as hits'),
                                DB::raw('SUM(positions.hit_last_game)    as hit_last_games'),
                                DB::raw('SUM(positions.dif_total_points) as dif_total_points'))
            ->Join('positions', 'positions.user_id', '=', 'users.id')
            ->where('users.active','1')
            ->groupBy('users.id')
            ->orderby('hits')
            ->orderby('hit_last_games')
            ->orderby('dif_total_points')
            ->paginate(15);
    dd($positions);
});


Route::get('crear-perfil/{user}',function(User $user){
    $datos = User::orderBy('id','DESC')->limit(20)->get();
    dd($datos);
    dd( $user->create_missing_picks());

    $entidad = Entidad::all()->random();
    dd($entidad,$entidad->municipios->random());
    if(!$user->profile){
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->save();

    }
    $user->refresh();
    dd($user->profile);
    dd($user->first_name . ' ' . $user->last_name. '->' . $user->email);
});
