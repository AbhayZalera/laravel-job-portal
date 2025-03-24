<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $site_settings = array(
            array(
                "id" => 1,
                "key" => "site_name",
                "value" => "JOBLIST",
                "created_at" => "2025-02-18 05:57:34",
                "updated_at" => "2025-02-18 05:57:34",
            ),
            array(
                "id" => 2,
                "key" => "site_email",
                "value" => "joblist@g.c",
                "created_at" => "2025-02-18 05:57:34",
                "updated_at" => "2025-02-18 05:57:34",
            ),
            array(
                "id" => 3,
                "key" => "site_phone",
                "value" => "9898989899",
                "created_at" => "2025-02-18 05:57:34",
                "updated_at" => "2025-02-18 06:32:08",
            ),
            array(
                "id" => 4,
                "key" => "site_default_currency",
                "value" => "USD",
                "created_at" => "2025-02-18 05:57:34",
                "updated_at" => "2025-02-18 10:39:12",
            ),
            array(
                "id" => 5,
                "key" => "site_currency_icon",
                "value" => "$",
                "created_at" => "2025-02-18 05:57:34",
                "updated_at" => "2025-02-18 10:39:12",
            ),
            array(
                "id" => 6,
                "key" => "site_map",
                "value" => "<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14269.79596302978!2d72.55620902485168!3d23.024391839414704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1741697132123!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>",
                "created_at" => "2025-03-11 12:45:45",
                "updated_at" => "2025-03-11 12:45:45",
            ),
        );

        \DB::table('site_settings')->insert($site_settings);
    }
}
