<?php
namespace Database\Factories;

use App\Models\Performa;
use App\Models\Koperasi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PerformaFactory extends Factory
{
    protected $model = Performa::class;

    public function definition(): array
    {
        
        $bdi = $this->faker->randomFloat(2, 0, 1);
        $odi = $this->faker->randomFloat(2, 0, 1);

        
        $cdi = round(($bdi + $odi) / 2, 2);

        
        if ($bdi > 0.5 && $odi > 0.5) {
            $kuadrant = '1';
        } elseif ($bdi > 0.5) {
            $kuadrant = '2';
        } elseif ($odi > 0.5) {
            $kuadrant = '3';
        } else {
            $kuadrant = '4';
        }

        return [
            'koperasi_id' => Koperasi::inRandomOrder()->value('id'),
            'bdi' => $bdi,
            'odi' => $odi,
            'cdi' => $cdi,
            'kuadrant' => $kuadrant,
            'periode' => Carbon::now()->subMonths(rand(0, 11))->startOfMonth(),
        ];
    }

    
    public function periode($date)
    {
        return $this->state(fn () => [
            'periode' => $date,
        ]);
    }
}
