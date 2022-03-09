<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presenza;

class PresenzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Presenza::factory()->count(5)->create();
    }
}
