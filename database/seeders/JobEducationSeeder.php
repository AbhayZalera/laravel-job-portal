<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educations = [
            'intermediate',
            'Bechelor Degree',
            'PhD',
            'High School',
            'Any'
        ];
        foreach ($educations as $education) {
            $create = new Education();
            $create->name = $education;
            $create->save();
        }
    }
}
