<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++){
            DB::table('categories')->insert([
                'name' => 'Category ' . $i,
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }

    }
}
