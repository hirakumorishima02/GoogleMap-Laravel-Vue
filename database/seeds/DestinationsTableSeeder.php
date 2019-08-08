<?php

use Illuminate\Database\Seeder;

class DestinationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('destinations')->insert([
            ['name'=>'我が家','lat'=>34.9260729,'lng'=>135.8164532,'photo'=>''],
            ['name'=>'別の家','lat'=>34.0796546,'lng'=>136.8252857,'photo'=>''],
        ]);
    }
}
