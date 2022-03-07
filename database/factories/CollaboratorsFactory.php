<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Collaborators;

class CollaboratorsFactory extends Factory
{

    protected $model = Collaborators::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->firstName(),
            'cognome' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'telefono' => $this->faker->phoneNumber(),
            'citta' => $this->faker->city(),
            'indirizzo' => $this->faker->address(),
            'intera_giornata' => $this->faker->randomDigit(),
            'mezza_giornata' => $this->faker->randomDigit(),
            'giornata_estero' => $this->faker->randomDigit(),
            'giornata_formazione' => $this->faker->randomDigit(),
        ];
    }
}
