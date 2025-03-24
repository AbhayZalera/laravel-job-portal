<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_menus = array(
            array(
                "id" => 1,
                "name" => "Navigation Menu",
                "created_at" => "2025-03-12 12:24:05",
                "updated_at" => "2025-03-12 12:24:06",
            ),
            array(
                "id" => 2,
                "name" => "Footer Menu Two",
                "created_at" => "2025-03-12 09:26:10",
                "updated_at" => "2025-03-12 09:26:31",
            ),
            array(
                "id" => 4,
                "name" => "Footer Menu One",
                "created_at" => "2025-03-12 09:32:55",
                "updated_at" => "2025-03-12 09:32:55",
            ),
            array(
                "id" => 6,
                "name" => "Footer Menu Three",
                "created_at" => "2025-03-12 09:34:01",
                "updated_at" => "2025-03-12 09:34:01",
            ),
            array(
                "id" => 8,
                "name" => "Footer Menu Four",
                "created_at" => "2025-03-12 09:34:38",
                "updated_at" => "2025-03-12 09:34:38",
            ),
        );
        \DB::table('admin_menus')->insert($admin_menus);
    }
}
