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


    public function calculate(){

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

        function getChange($amount_owed, $amount_paid){
            $change_due=[];

            // case where whole dollar is not due, only change
            if($amount_paid[0]-$amount_owed[0]==1&&$amount_owed[1]>$amount_paid[1]){
                $cash_due=0;
            } else{
                // cash kept in first index, coins in second
                $cash_due= $amount_paid[0]-$amount_owed[0];
            }

            $change_due[0]=$cash_due;

            // if there are no coins or the value of coins in amount paid & due is equal. No coins are due
            if(($amount_owed[1]==0 && $amount_paid[1]==0) || $amount_owed[1]==$amount_paid[1]){

                $change_due[1]=00;

                // if no change owed but change paid, give change back
            } else if($amount_owed[1]==0 && $amount_paid[1]>0) {

                $change_due[1]=$amount_paid[1];
              // change owed greater than change paid
            } else if($amount_owed[1]>$amount_paid[1]) {
                // formula for getting over paid change
                $change_due[1]= ($amount_paid[1]-$amount_owed[1]) + 100;
              //change paid is greater than change owed
            } else{
                $change_due[1]= $amount_paid[1]-$amount_owed[1];
            }

            return $change_due;
        }



        function getMinCash($cash, $amount_to_give_back){

            // amount + 1 because we want indices from 0-amount
            // initial value is infinity because we are working with minimums
            $min_coins= array_fill(0, $amount_to_give_back+1,INF);

            // first index value will 0 because you cannot make value 0 from 	any coin combinations
            $min_coins[0]=0;
            $min_coins_length=count($min_coins);

            // looking at each coin
            foreach ($cash as $key => $cash_value) {

            // for each coin find coin combos for 0-amount_to_give_back
                for($i = 0; $i< $min_coins_length; $i++) {


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

                    // reverse array, keep numeric keys the same
                    $cash_count_array= array_reverse($cash,true);

                    // replace all values with 0
                    $cash_count_array=array_map(function($val) { return $val=0; }, $cash_count_array);

                    // loop over reverse cash arr
                    //initialize cash_back to amount of change needed to giveback
                    $cash_back=$amount_to_give_back;
                    $index = 0;
                    foreach ($cash_count_array as $key => &$count){
                        $index++;

                        // turn current coin key into int and set as current cash value on first iteration
                        $current_cash_value=intval($key);

                        // get the remainder from cash owed/current_cash_value
                        $remainder=$cash_back % $current_cash_value;

                        //if cash due is divisible by the current cash amount it will return value, if it is not it will return 0
                        $cash_count=intdiv($cash_back,$current_cash_value);

                        // current index value($count), cash_count_array keeps track of our coin count
                        // set equal to current coin count from int division above
                        $count= $cash_count;


                        $current_cash_value=$remainder;

                        // update cash_back amount to remainder
                        $cash_back=$remainder;


                    }

                    //unset count variable so it is only defined inside of loop
                    unset($count);


                    return['cash_back'=>$amount_to_give_back,'cash_count'=>$cash_count_array,'min_cash'=>$min_coins[$amount_to_give_back]];

                } else{

                    return -1;

                }

        };

        // figure out if amounts submitted are floating point values
        // return transaction as array, cash in first change in second
        $amount_paid=isFloat(request("amount_paid"));
        $amount_owed= isFloat(request("amount_owed"));

        //getChange returns array with cash and coins due back
        $change=getChange($amount_owed,$amount_paid);


        $dollars =["1"=>1,"5"=>5,"10"=>10,"20"=>20,"50"=>50,"100"=>100];
        $coins =["1"=>1,"5"=>5,"10"=>10,"25"=>25];





        $response= ["cash"=>getMinCash($dollars,$change[0]),"coins" =>getMinCash($coins,$change[1]),"amount_paid_cash"=>$amount_paid[0], "amount_paid_coins"=>$amount_paid[1], "amount_owed_cash"=>$amount_owed[0], "amount_owed_coins"=>$amount_owed[1] ];


        // update transaction and save
        $transaction=Transaction::find(request("transactionId"));
        $transaction->amount_paid_cash= $amount_paid[0];
        $transaction->amount_paid_coins= $amount_paid[1];
        $transaction->amount_owed_cash= $amount_owed[0];
        $transaction->amount_owed_coins= $amount_owed[1];
        $transaction->save();


        return $response;
    }

}

