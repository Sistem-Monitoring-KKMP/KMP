<?php
namespace Database\Factories;

use App\Models\Pengurus;
use App\Models\Koperasi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengurusFactory extends Factory
{
    
    protected $model = Pengurus::class;

    public function definition(): array
    {
        return [
            'koperasi_id' => Koperasi::inRandomOrder()->first()->id,
            'nama' => $this->faker->name(),
            'jabatan' => $this->faker->randomElement([
                'Ketua','WakilBU','WakilBA','Sekretaris',
                'Bendahara','KetuaPengawas','Pengawas','GeneralManager'
            ]),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'usia' => $this->faker->numberBetween(25, 60),

            'pendidikan_koperasi' => $this->faker->boolean(40),
            'pendidikan_ekonomi' => $this->faker->boolean(40),
            'pelatihan_koperasi' => $this->faker->boolean(40),
            'pelatihan_bisnis' => $this->faker->boolean(40),
            'pelatihan_lainnya' => $this->faker->boolean(20),

            'tingkat_pendidikan' => $this->faker->randomElement([
                'sd','sltp','slta','diploma','sarjana','pascasarjana'
            ]),

            'keaktifan_kkmp' => $this->faker->randomElement([
                'aktif','cukup aktif','kurang aktif'
            ]),
        ];
    }

    public function jabatan(string $jabatan)
    {
        return $this->state(fn () => [
            'jabatan' => $jabatan,
        ]);
    }
}
