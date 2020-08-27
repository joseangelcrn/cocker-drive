<?php

use App\LogType;
use Illuminate\Database\Seeder;

class LogTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        LogType::truncate();
        LogType::insert(
           [
            ['name'=>'deleted'],
            ['name'=>'renamed'],
            ['name'=>'uploaded'],
           ]
        );
    }
}
