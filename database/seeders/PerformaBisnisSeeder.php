<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Performa;
use App\Models\PerformaBisnis;
use Illuminate\Database\Seeder;

class PerformaBisnisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Performa::all()->each(function ($performa) {
        PerformaBisnis::factory()->create([
        'performa_id' => $performa->id,
    ]);
});
    }
}
