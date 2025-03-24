<?php

namespace Database\Seeders;

use App\Models\JobExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $experiences = [
            'Fresher',
            '1 Year',
            '2 Year',
            '3+ Year',
            '5+ Year',
            '8+ Year',
            '10+ Year',
            '15+ Year',
            '20+ Year'
        ];
        foreach ($experiences as $experience) {
            $create = new JobExperience();
            $create->name = $experience;
            $create->save();
        }
    }
}
