<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('projects')->delete();

        \DB::table('projects')->insert([
            [
                'name'=> '双眼皮'
            ],
            [
                'name'=> '植发'
            ],
        ]);
    }
}
