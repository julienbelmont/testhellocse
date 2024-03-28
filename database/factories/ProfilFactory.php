<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\Image;
use App\Models\Profil;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProfilFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'nom' => fake()->name(),
            'prenom' => fake()->name(),
            'image' => 'url',
            'statut' => fake()->randomElement(['ACTIVE', 'INACTIVE', 'PENDING'])
        ];
    }


    /**
     * Configure the factory.
     *
     * @return static
     */
    public function configure()
    {
        return $this->afterCreating(function (Profil $profil) {

            $filePath = Image::fake(
                storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $profil->id),
                /** width: */ 640,
                /** height: */ 480,
                /** randomizeColors: */ false,
                /** randomizeTxt: */ false,
                /** format: */ 'jpg',
                /** fullPath: */ false
            );

            $currentURL = url()->full();

            $profil->image = $currentURL.'/storage/'.$profil->id.'/'.$filePath;
            $profil->save();
        });
    }
}
