<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {


        DB::table('transactions')->insert([
            'amount_owed'=> rand(1,20),
            'amount_paid'=> rand(21,100),
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
    }
}
