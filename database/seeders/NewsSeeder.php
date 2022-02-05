<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(0, 20) as $number) {
            # code...
            DB::table('news')->insert([
                'title' => $number.'---'.Str::random(10),
                'content' => Str::random(100) . ' test content'
            ]);
        }
    }
}
