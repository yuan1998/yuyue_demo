<?php

use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_permissions')->delete();
        
        \DB::table('admin_permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '所有权限',
                'slug' => '*',
                'http_method' => '',
                'http_path' => '*',
                'created_at' => NULL,
                'updated_at' => '2019-07-29 09:07:28',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '查看首页',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
                'created_at' => NULL,
                'updated_at' => '2019-07-29 09:07:54',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '登录权限',
                'slug' => 'auth.login',
                'http_method' => '',
                'http_path' => '/auth/login
/auth/logout',
                'created_at' => NULL,
                'updated_at' => '2019-07-29 09:08:07',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '用户设置',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
                'created_at' => NULL,
                'updated_at' => '2019-07-29 09:08:36',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '系统管理',
                'slug' => 'auth.management',
                'http_method' => '',
                'http_path' => '/auth/roles
/auth/permissions
/auth/menu
/auth/logs',
                'created_at' => NULL,
                'updated_at' => '2019-07-29 09:09:06',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '创建预约',
                'slug' => 'reservation.store',
                'http_method' => 'POST',
                'http_path' => '/reservations',
                'created_at' => '2019-07-29 09:02:31',
                'updated_at' => '2019-07-29 09:09:20',
            ),
        ));
        
        
    }
}