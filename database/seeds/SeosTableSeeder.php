<?php

use Illuminate\Database\Seeder;
use App\Seo;

class SeosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seo::create([
            'url' => 'main',
            'page' => 'Главная'
        ]);
    }
}
