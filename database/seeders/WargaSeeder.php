<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('wargas')->insert([
                       'nama'   => 'Andi Firmansyah',
                       'nik'    =>  '368762526753765',
                       'tglLahir' => '04/06/1999',
                       'provinsi_id' =>$provinsi,
                       'kota_id' =>$kota,
                       'kecamatan_id' =>$kecamatan,
                       'kelurahan_id' =>$kelurahan,
                       'alamat' =>  $alamat,
                       'jeniskelamin'   =>  $jeniskelamin,
                       'nohp'   =>  $nohp
        ]);
    }
}
