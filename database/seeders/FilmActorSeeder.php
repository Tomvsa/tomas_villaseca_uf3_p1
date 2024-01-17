<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Film;
use App\Models\FilmActor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = Film::all();
        $actors = Actor::all();

        foreach ($films as $film) {
            $actorsToAttach = $actors->random(rand(1, 3))->pluck('id');
            
            foreach ($actorsToAttach as $actorId) {
                FilmActor::create([
                    'film_id' => $film->id,
                    'actor_id' => $actorId,
                ]);
            }
        }
    }
}
