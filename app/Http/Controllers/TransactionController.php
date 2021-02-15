<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(){
        $transaction=Transaction::All();
        $response= array("transaction"=>$transaction);

        return $response;
    }

    public function calculate(Request $request){
        $transaction=Transaction::All();
        $response= array(
            "transaction"=>$transaction,

        );

        return $response;
    }
}
