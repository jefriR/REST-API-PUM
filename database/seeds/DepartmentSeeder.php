<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'DACC',
            'description' => 'DEPT ACCOUNTING'
        ]);

        DB::table('departments')->insert([
            'name' => 'DBO',
            'description' => 'DEPT BACK OFFICE'
        ]);

        DB::table('departments')->insert([
            'name' => 'DMKT',
            'description' => 'DEPT MARKETING'
        ]);

        DB::table('departments')->insert([
            'name' => 'DLOG',
            'description' => 'DEPT LOGISTIK'
        ]);

        DB::table('departments')->insert([
            'name' => 'DTAX',
            'description' => 'DEPT TAX'
        ]);


    }
}
