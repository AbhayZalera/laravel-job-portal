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
        $languages = [
            'English',
            'Hindi',
            'Gujarati',
            'Arabic',
            'Bangla'
        ];
        foreach ($languages as $language) {
            $lang = new Language();
            $lang->name = $language;
            $lang->save();
        }
    }
}
