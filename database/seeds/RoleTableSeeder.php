<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('role')->insert([
            'id' => '1',
            'nama' => 'Superuser',
         ]);

         DB::table('role')->insert([
            'id' => '2',
            'nama' => 'Administrator Sistem',
         ]);
         DB::table('role')->insert([
            'id' => '3',
            'nama' => 'Administrator OPD',
         ]);
         DB::table('role')->insert([
            'id' => '4',
            'nama' => 'Pegawai/Peminjam Ruangan',
         ]);
    }
}
