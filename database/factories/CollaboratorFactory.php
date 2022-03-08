<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Collaborator;

class CollaboratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->firstNameMale(),
            'cognome' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'telefono' => 3254465,
            'citta' => $this->faker->city(),
            'indirizzo' => $this->faker->address(),
            'CAP' => '64025',
            'intera_giornata' => $this->faker->randomDigit(),
            'mezza_giornata' => $this->faker->randomDigit(),
            'giornata_estero' => $this->faker->randomDigit(),
            'giornata_formazione' => $this->faker->randomDigit(),
        ];
    }
}
