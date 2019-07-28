<?php

use Illuminate\Database\Seeder;

class SchedulingStatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('scheduling_statuses')->delete();
        
        \DB::table('scheduling_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '全天休息',
                'begin_time' => NULL,
                'end_time' => NULL,
                'all_day' => 1,
                'created_at' => '2019-07-25 17:31:48',
                'updated_at' => '2019-07-25 17:31:48',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '下午休息',
                'begin_time' => '12:00:00',
                'end_time' => '23:00:00',
                'all_day' => 0,
                'created_at' => '2019-07-25 17:43:19',
                'updated_at' => '2019-07-25 17:43:19',
            ),
            2 => 
            array (
                'id' => 7,
                'name' => '上午休息',
                'begin_time' => '07:00:00',
                'end_time' => '12:00:00',
                'all_day' => 0,
                'created_at' => '2019-07-25 18:04:11',
                'updated_at' => '2019-07-25 18:04:11',
            ),
        ));
        
        
    }
}