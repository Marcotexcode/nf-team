<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collaborators;

class CollaboratorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collaborators::factory()->count(10)->create();
       // \App\Models\Collaborators::factory(10)->create();
    }
}
