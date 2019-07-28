<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_users')->delete();
        
        \DB::table('admin_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$ze1dfdNXt6QpIuuRzFEl.umMF7WXxRDbXs7a/96C04vIir01ARLA.',
                'name' => 'Administrator',
                'avatar' => NULL,
                'remember_token' => 'bvuDZq7SQXNC8ktqOTyB1lTa4KWKzm1S4ucaOh6SoUKepoPtsllDa78JhU2T',
                'created_at' => '2019-07-23 18:27:20',
                'updated_at' => '2019-07-23 18:27:20',
            ),
        ));
        
        
    }
}