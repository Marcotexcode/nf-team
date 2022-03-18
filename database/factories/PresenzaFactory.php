<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PresenzaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'data_inizio' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'data_fine' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'collaborator_id'=> 1,
            'importo' => $this->faker->randomDigit(),
            'tipo_di_presenza' => $this->faker->firstNameMale(),
            'luogo'=> $this->faker->city(),
            'descrizione' => $this->faker->randomDigit(),
            'spese_rimborso' => $this->faker->randomDigit(),
            'bonus' => $this->faker->randomDigit(),
        ];
    }
}
