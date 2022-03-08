<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collaborator;

class CollaboratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collaborator::factory()->count(5)->create();
    }
}
