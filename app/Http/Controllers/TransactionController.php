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

                // call calculate

                return $int_values;

            } else {
                // not a float return array with 0 for cents
                return $int_values= array(intval($string),0);
            }
        }

        $amount_paid=isFloat(request("amount_paid"));
        $amount_owed= isFloat(request("amount_owed"));


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
