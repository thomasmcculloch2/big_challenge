<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Constants\Rol;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleDoctor = Role::create(['name' => Rol::DOCTOR]);
        $rolePatient = Role::create(['name' => Rol::PATIENT]);
        Submission::factory(20)->create();
    }
}
