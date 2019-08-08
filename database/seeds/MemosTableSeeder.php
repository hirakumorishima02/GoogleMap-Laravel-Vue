<?php

use Illuminate\Database\Seeder;

class MemosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memos')->insert([
            ['destination_id'=>1,'content'=>'memo1のcontentです。'],
            ['destination_id'=>2,'content'=>'memo2のcontentです。'],
            ['destination_id'=>3,'content'=>'memo3のcontentです。'],
        ]);
    }
}
