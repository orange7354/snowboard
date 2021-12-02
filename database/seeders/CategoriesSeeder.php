<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [   'id' =>'1',
                'category_name' => 'ハーフパイプ'],
            [   'id' =>'2',
                'category_name' => 'フリーラン'],
            [   'id' =>'3',
                'category_name' => 'グラトリ'],
            [   'id' =>'4',
                'category_name' => 'キッカー'],
            [   'id' =>'5',
                'category_name' => 'ジブ'],
            [   'id' =>'6',
                'category_name' => 'その他']
        ]);
    }
}
