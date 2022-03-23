<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collaboratore;

class CollaboratoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collaboratore::factory()->count(5)->create();
    }
}
