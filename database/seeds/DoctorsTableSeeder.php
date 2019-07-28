<?php

use Illuminate\Database\Seeder;

class DoctorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('doctors')->delete();

        \DB::table('doctors')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => '医生1',
                'description' => NULL,
                'created_at' => '2019-07-25 22:52:05',
                'updated_at' => '2019-07-25 22:52:05',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => '医生2',
                'description' => NULL,
                'created_at' => '2019-07-25 22:52:11',
                'updated_at' => '2019-07-25 22:52:11',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => '医生3',
                'description' => NULL,
                'created_at' => '2019-07-25 22:52:17',
                'updated_at' => '2019-07-25 22:52:17',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => '医生5',
                'description' => NULL,
                'created_at' => '2019-07-25 22:52:25',
                'updated_at' => '2019-07-25 22:52:25',
            ),
        ));


    }
}
