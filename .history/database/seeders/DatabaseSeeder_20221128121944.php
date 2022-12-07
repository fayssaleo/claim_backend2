<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\Department\Models\Department;
use App\Modules\Fonction\Models\Fonction;
use App\Modules\User\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $department=new Department();
        $department->name="IT";
        $department->save();


        $fonction=new Fonction();
        $fonction->name="Engineer";
        $fonction->department_id=$department->id;
        $fonction->save();

        $user=new User();
        $user->username="test";
        $user->lastName="test";
        $user->firstName="test";
        $user->email="test";
        $user->password="test";
        $user->phoneNumber="test";
        $user->fonction_id=$fonction->id;
        $user->save();

    }
}
