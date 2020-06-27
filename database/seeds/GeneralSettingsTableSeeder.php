<?php

use Illuminate\Database\Seeder;
use App\GeneralSetting;

class GeneralSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorys = [
            ['id' => 1, 'site_name' => 'test'],
         ];

        foreach ($categorys as $category) {
            GeneralSetting::create($category);
        }
    }
}
