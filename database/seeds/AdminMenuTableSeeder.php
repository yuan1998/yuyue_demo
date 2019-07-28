<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => '仪表盘',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-24 02:43:21',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 8,
                'title' => '系统管理',
                'icon' => 'fa-tasks',
                'uri' => NULL,
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-25 21:27:35',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 9,
                'title' => '用户管理',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-25 21:27:35',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 10,
                'title' => '角色管理',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-25 21:27:35',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 11,
                'title' => '权限管理',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-25 21:27:35',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 12,
                'title' => '菜单管理',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-25 21:27:35',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 13,
                'title' => '日志管理',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-07-25 21:27:35',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 2,
                'title' => '医生管理',
                'icon' => 'fa-hospital-o',
                'uri' => '/doctors',
                'permission' => NULL,
                'created_at' => '2019-07-24 02:53:05',
                'updated_at' => '2019-07-24 02:53:11',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 0,
                'order' => 3,
                'title' => '预约管理',
                'icon' => 'fa-american-sign-language-interpreting',
                'uri' => '/reservations',
                'permission' => NULL,
                'created_at' => '2019-07-24 03:01:10',
                'updated_at' => '2019-07-25 20:12:43',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 11,
                'order' => 6,
                'title' => '排班状态',
                'icon' => 'fa-bars',
                'uri' => '/scheduling-status',
                'permission' => NULL,
                'created_at' => '2019-07-25 02:56:59',
                'updated_at' => '2019-07-25 21:27:35',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'order' => 5,
                'title' => '排班',
                'icon' => 'fa-calendar',
                'uri' => '/scheduling',
                'permission' => NULL,
                'created_at' => '2019-07-25 20:11:19',
                'updated_at' => '2019-07-25 21:27:35',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 11,
                'order' => 7,
                'title' => '医生排班管理',
                'icon' => 'fa-bars',
                'uri' => '/scheduling',
                'permission' => NULL,
                'created_at' => '2019-07-25 20:11:54',
                'updated_at' => '2019-07-25 21:27:35',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 0,
                'order' => 4,
                'title' => '项目管理',
                'icon' => 'fa-hand-peace-o',
                'uri' => '/projects',
                'permission' => NULL,
                'created_at' => '2019-07-25 21:26:40',
                'updated_at' => '2019-07-25 21:27:35',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 11,
                'order' => 0,
                'title' => '排班表',
                'icon' => 'fa-500px',
                'uri' => '/scheduling/table',
                'permission' => NULL,
                'created_at' => '2019-07-27 03:24:40',
                'updated_at' => '2019-07-27 03:25:18',
            ),
        ));
        
        
    }
}