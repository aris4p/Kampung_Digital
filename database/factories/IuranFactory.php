<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Iuran;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class IuranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

       protected $model = Iuran::class;


    public function definition()
    {
        return [
            'idtrx' => 'TRX'.Str::random(20),
            'jenistrx' => Str::random(5),
            'tgltrx' => Carbon::parse('2000-01-01'),
            'statustrx' => rand('0','1'),
        ];
    }
}
