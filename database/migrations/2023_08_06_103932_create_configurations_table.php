<?php

use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuration', function (Blueprint $table) {
            $table->id();
            $table->string('website_name')->comment('Nombre del website');
            $table->string('website_url')->nullable()->comment('Url');
            $table->string('email')->nullable()->comment('Correo');
            $table->boolean('score_picks')->default(0)->comment('Puntos en pronósticos');
            $table->integer('minuts_before_picks')->default(5)->comment('Minutos antes para pronóstico');
            $table->boolean('allow_tie')->default(0)->comment('¿Permitir empate?');
            $table->boolean('create_mssing_picks')->default(0)->comment('¿Crear pronósticos faltantes?');
            $table->boolean('require_payment_to_continue')->default(1)->comment('¿Require pago para continuar?');
            $table->boolean('require_data_user_to_continue')->default(1)->comment('¿Requiere datos complementarios para continuar?');
            $table->boolean('assig_role_to_user')->default(0)->comment('¿Asignar Rol al registrarse?');
            $table->boolean('add_user_to_stripe')->default(0)->comment('¿Agregar usuario a Stripe?');
            $table->boolean('use_team_to_tie_breaker')->default(0)->comment('¿Usar un Equipo para desempate?');
            $table->foreignIdFor(Team::class)->comment('Equipo para desempate');
            $table->boolean('require_points_in_picks')->default(1)->comment('¿Solicitar puntos en pronósticos?');
            $table->integer('points_to_hit_tie_breaker_game')->default(4)->comment('Puntos por acertar partido de desempate');
            $table->integer('points_to_hit_game')->default(1)->comment('¿Solicitar puntos en pronósticos?');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration');
    }
};
