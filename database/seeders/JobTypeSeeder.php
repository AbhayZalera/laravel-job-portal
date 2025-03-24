<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $job_types = array(
            "Full-time",
            "Part-time",
            "Contract",
            "Temporary",
            "Remote",
            "Freelance",
            "Internship",
            "Entry-level",
            "Mid-level",
            "Senior-level"
        );
        foreach ($job_types as $type) {
            $types = new JobType();
            $types->name = $type;
            $types->save();
        }
    }
}
