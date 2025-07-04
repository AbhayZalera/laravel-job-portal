<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artisan;
use File;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function Laravel\Prompts\alert;

class ClearDatabaseController extends Controller
{

    function __construct()
    {
        $this->middleware(['permission:database clear']);
    }

    function index(): View
    {
        return view('admin.clear-database.index');
    }

    function clearDatabase()
    {
        // alert('Jay Mataji');
        // dd('Jay Mataji');
        try {
            // wipe database
            Artisan::call('migrate:fresh');
            // seed default data
            Artisan::call('db:seed', ['--class' => 'RolePermissionSeeder']);
            Artisan::call('db:seed', ['--class' => 'AdminSeeder']);
            Artisan::call('db:seed', ['--class' => 'SiteSettingsSeeder']);
            Artisan::call('db:seed', ['--class' => 'MenuSeeder']);
            Artisan::call('db:seed', ['--class' => 'PaymentSettingSeeder']);
            // delete files
            $this->deleteFiles();

            return response(['message' => 'Database wiped successfully!']);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    function deleteFiles(): void
    {
        $path = public_path('uploads');
        $allFlies = File::allFiles($path);

        foreach ($allFlies as $file) {
            $filename = $file->getFilename();

            File::delete($filename);
        }
    }
}
