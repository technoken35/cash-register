<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TransactionController extends Controller
{
    public function index(){
        $transaction=Transaction::All();
        $response= array("transaction"=>$transaction);

        return $response;
    }


    public function calculate(Request $request){

        function isFloat($string){
            // check if string contains decimal point
            if(str_contains($string,'.')){

                // split string into arr after decimal, turn values into integers
                $int_values= array_map('intval',explode('.',$string));

                return $int_values;

            } else {
                // not a float return array with 0 for cents
                return $int_values= array(intval($string),0);
            }
        }


        $amount=20;
        $dollars =["penny"=>1,"nickel"=>5,"dime"=>10];





        $amount=18;
        $dollars =["1"=>1,"5"=>5,"10"=>10];

        function getChange($cash, $amount_to_give_back){

            // amount + 1 because we want indices from 0-amount
            // initial value is infinity because we are working with minimums
            $min_coins= array_fill(0, $amount_to_give_back+1,INF);

            // first index value will 0 because you cannot make value 0 from 	any coin combinations
            $min_coins[0]=0;
            $min_coins_length=count($min_coins);

            // looking at each coin
            foreach ($cash as $key => $cash_value) {


            // for each coin find coin combos for 0-amount_to_give_back
                for($i = 0; $i<= $min_coins_length; $i++) {


                    // make sure the difference between the current amount and the current coin is at least 0
                    if(($i-$cash_value) >=0){

                        // replace old value
                        $min_coins[$i]= min($min_coins[$i-$cash_value]+1,$min_coins[$i]);

                    }
                }

            }


        // if the value remains Infinity, it means that no coin combination can make that amount
                if(floatval($min_coins[$amount_to_give_back])!=INF){

                    // minimum amount of coins will be last value in array after calculations are done
                    //    echo "{$min_coins[$amount_to_give_back]} min number of coins <br>";

                    // reverse array, keep numeric keys the same
                    $cash_count_array= array_reverse($cash,true);

                    // replace all values with 0
                    $cash_count_array=array_map(function($val) { return $val=0; }, $cash_count_array);



                    // loop over reverse cash arr
                    //initialize cash_back to amount of change needed to giveback
                    $cash_back=$amount_to_give_back;
                    $index = 0;
                    foreach ($cash_count_array as $key => $count){
                        echo"start of loop <br>";
                        $index++;

                        // turn current coin key into int and set as current cash value on first iteration
                        $current_cash_value=intval($key);

                        // get the remainder from cash owed/current_cash_value
                        $remainder=$cash_back % $current_cash_value;

                        //if cash due is divisible by the current cash amount it will return value, if it is not it will return 0
                        $cash_count=intdiv($cash_back,$current_cash_value);

                        // current index value, cash_count_array keeps track of our coin count
                        // set equal to current coin count from int division above
                        $count= $cash_count;


                        $current_cash_value=$remainder;

                        // update cash_back amount to remainder
                        $cash_back=$remainder;

                        echo "${remainder} remainder <br>";
                        echo "${current_cash_value} current cash value <br>";
                        echo "key: {$key} value: {$count} of each coin <br>";
                        echo "{$cash_count} cash count <br>";
                    }


                } else{

                echo "hello pt 3 <br>";

                }

                echo "end of script";

        };

        getChange($dollars,$amount);


        $amount_paid=isFloat(request("amount_paid"));
        $amount_owed= isFloat(request("amount_owed"));

        // call getChange


    /*  $transaction=Transaction::find(request("transactionId"));
        $transaction->amount_paid= request("amount_paid");
        $transaction->amount_owed= request("amount_owed");
        $transaction->save(); */

        $response= array(
            //"transaction"=>$transaction,
            "response"=>"hello from response array",
            "amount_paid"=>$amount_paid,
            "amount_owed"=>$amount_owed,
        );

        return $response;
    }

}

