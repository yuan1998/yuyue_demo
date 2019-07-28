<?php

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
//         $this->call(UsersTableSeeder::class);
        $this->call(SchedulingStatusesTableSeeder::class);
        $this->call(AdminMenuTableSeeder::class);
        $this->call(AdminUsersTableSeeder::class);
        $this->call(AdminRolesTableSeeder::class);
        $this->call(AdminPermissionsTableSeeder::class);
        $this->call(AdminRoleUsersTableSeeder::class);
        $this->call(AdminUserPermissionsTableSeeder::class);
        $this->call(AdminRolePermissionsTableSeeder::class);
        $this->call(AdminRoleMenuTableSeeder::class);
        $this->call(DoctorsTableSeeder::class);
        $this->call(ProjectSeeder::class);
    }
}
