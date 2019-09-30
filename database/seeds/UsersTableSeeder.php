<?php

use App\Role\UserRole;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function($user) {
            $role_id = rand(0, 1);
            if ($role_id === 0) {
                $role = UserRole::ROLE_ADMIN;
            } else {
                $role = UserRole::ROLE_TEACHER;
            }
            $user->addRole($role);
            $user->save();
        });
    }
}
