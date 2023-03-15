<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('iurans')->insert([
            'idtrx' => 'trx'.Str::random(20),
            'jenistrx' => Str::random(20),
            'tgltrx' => Carbon::parse('2000-01-01'),
            'statustrx' => rand('1','2'),
        ]);
    }
}
