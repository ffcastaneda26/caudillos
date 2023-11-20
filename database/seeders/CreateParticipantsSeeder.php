<?php

namespace Database\Seeders;

use App\Models\Profile;
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
        $count_users = 5;
        User::factory()
                ->count($count_users)
                ->create([
                    'adult'  => 1,
                    'paid'  => 1,
                    'active' => 1
                ])->each(function ($user) {
                    $profile = Profile::factory()->make();
                    $user->profile()->save($profile);
                    $user->assignRole(env('ROLE_TO_PARTICIPANT','participante'));
                    $user->create_missing_picks();
                });


        // $users = User::where('id','>',1)->orderBy('id')->get();
        // foreach( $users as $user){
        //     $user->assignRole(env('ROLE_TO_PARTICIPANT','participante'));
        //     $user->create_missing_picks();
        // }


    }
}
