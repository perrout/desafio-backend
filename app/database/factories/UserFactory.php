<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $document = $this->faker->randomElement([$this->faker->unique()->cpf(false), $this->faker->unique()->cnpj(false)]);
        $type = (strlen($document) == 11) ? 'common' : 'trader';
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'document' => $document,
            'wallet' => $this->faker->randomFloat(2, $min = 0, $max = 1000),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => app('hash')->make($document),
            'status' => true,
            'type' => $type,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
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
