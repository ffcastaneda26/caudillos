<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateParticipantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count_users = 10;
        User::factory()->count($count_users)
                ->create([
                    'adult'  => 1,
                    'paid'  => 1,
                    'active' => 1
                ]);
        // User::factory()
        //         ->count($count_users)
        //         ->hasProfile(1)
        //         ->create([
        //             'adult'  => 1,
        //             'paid'  => 1,
        //             'active' => 1
        //         ]);

        $users = User::where('id','>',1)->orderBy('id')->get();
        foreach( $users as $user){
            $user->assignRole(env('ROLE_TO_PARTICIPANT','participante'));
            $user->create_missing_picks();
        }
    }
}
