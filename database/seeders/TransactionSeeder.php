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
            'amount_owed_cash'=> rand(1,20),
            'amount_owed_coins'=> rand(1,99),
            'amount_paid_cash'=> rand(21,100),
            'amount_paid_coins'=> rand(1,99),
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
    }
}
