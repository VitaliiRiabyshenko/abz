<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $filepath = public_path('images/users');

        if (!File::exists($filepath)) {
            File::makeDirectory($filepath, 0755, true);
        }

        $this->faker->addProvider(new \Faker\Provider\uk_UA\PhoneNumber($this->faker));

        $this->faker->addProvider(new FakerPicsumImagesProvider($this->faker));

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->e164PhoneNumber,
            'position_id' => Position::all()->random(),
            'image' => $this->faker->image($filepath)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
