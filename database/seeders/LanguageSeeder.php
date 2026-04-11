<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::create([
            'name' => 'English',
            'code' => 'en',
            'flag_code' => 'us',
            'is_active' => true,
        ]);

        Language::create([
            'name' => 'Chinese',
            'code' => 'zh',
            'flag_code' => 'cn',
            'is_active' => true,
        ]);

        Language::create([
            'name' => 'Korean',
            'code' => 'ko',
            'flag_code' => 'kr',
            'is_active' => true,
        ]);

        Language::create([
            'name' => 'Spanish',
            'code' => 'es',
            'flag_code' => 'es',
            'is_active' => true,
        ]);

        Language::create([
            'name' => 'French',
            'code' => 'fr',
            'flag_code' => 'fr',
            'is_active' => true,
        ]);
    }
}
