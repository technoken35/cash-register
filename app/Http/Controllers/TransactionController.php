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



        $amount=25;
        $dollars =["penny"=>1,"nickel"=>5,"dime"=>10];



        function getChange($cash, $amount_to_give_back){

            // amount + 1 because we want indices from 0-amount
            // initial value is infinity because we are working with minimums
            $min_coins= array_fill(0, $amount_to_give_back+1,INF);

            // first index value will 0 because you cannot make value 0 from 	any coin combinations
            $min_coins[0]=0;
            $min_coins_length=count($min_coins);


            // looking at each coin
            foreach ($cash as $key => $cash_value) {

            echo "inside of parent loop <br>";
            echo "{$min_coins_length} <br>";

                // for each coin find coin combos for 0-amount_to_give_back
                for($i = 0; $i<= $min_coins_length; $i++) {


                      // make sure the difference between the current amount and the current coin is at least 0
                    if(($i-$cash_value) >=0){
                        $test= $i-$cash_value;

                        // replace old value
                        $min_coins[$i]= min($min_coins[$i-$cash_value]+1,$min_coins[$i]);
                    }

                }

            }


            // if the value remains Infinity, it means that no coin combination can make that amount
            if(floatval($min_coins[$amount_to_give_back])!=INF){



                echo "{$min_coins[$amount_to_give_back]} <br>";

            } else{

            echo "hello pt 3 <br>";

            }

        };

        //getChange($dollars,$amount);



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

