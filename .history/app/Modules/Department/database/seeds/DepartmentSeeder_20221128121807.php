<?php

namespace Database\Seeders\Modules\Department\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Department\Models\Department;

use App\Modules\Fonction\Models\Fonction;
use Illuminate\Foundation\Auth\User;

class DepartmentSeeder extends Seeder
{

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

