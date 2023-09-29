<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Entidad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $entidad = Entidad::all()->random();
        $municipio = $entidad->municipios->random();

        return [
             'gender'       => $this->faker->randomElement(['Hombre','Mujer']),
             'birthday'     => Carbon::now()->subYear($this->faker->randomNumber(2))->format('Y-m-d'),
             'entidad_id'   => $entidad->id,
             'municipio_id' => $municipio->id,
        ];
    }
}
