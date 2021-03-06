<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            'key' => 'page_size',
            'value' => '25'
        ]);
    }
}
