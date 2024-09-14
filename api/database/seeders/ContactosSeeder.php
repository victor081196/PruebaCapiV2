<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [];
        for ($i = 0; $i <= 100; $i++) {
            $users[] = [
                'cts_nombre' => 'Prueba ' . $i,
                'cts_pagina_web' => 'www.prueba'.$i.'.com',
                'cts_notas' => '',
                'cts_empresa' => 'PRUEBA ' .$i . ' S.A. DE C.V',
            ];
        }

        DB::table('tbl_contactos_cts')->insert($users);
        // DB::table('tbl_contactos_cts')->insert([
        //     [
        //         'cts_nombre' => 'Victor Anzures',
        //         'cts_pagina_web' => 'www.prueba.com',
        //         'cts_notas' => '',
        //         'cts_empresa' => 'PRUEBA',
        //     ],
        // ]);
    }
}
