<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transfer(Request $request){
        $user = $request->user();
        $fields = $request->validate([
            'receiver_id' => ['exists:users,id', 'required', 'int'],
            'amount' => ['numeric']
        ]);
        $fields["sender_id"] = $user->id;
        
        if($user->balance>=$fields['amount']){
            if($user->balance>10000) return response()->json(["message"=>"Bad request"],400);

            $user->balance -= $fields['amount'];
            $user->save();
            
            $fields["status"] = "success";

            $transaction = Transaction::create($fields);
            return response()->json($transaction,201);
        }

        $fields["status"] = "failed";
        $transaction = Transaction::create($fields);
        return response()->json(["message" => "Insufiscient amount"], 400);
        

        
    } 

    public function topup(Request $request){
        $user = $request->user();
        $fields = $request->validate([
            'topup_amount' => ['numeric', 'required', 'min:1']
        ]);
        $fields['user_id'] = $user->id;
        if($fields['topup_amount']>10000) return response()->json(["message" => "Bad request"], 400);
        
        $user->balance += $fields['topup_amount'];
        $fields['balance'] = $user->balance;

        $user->save();
        $topup = Topup::create($fields);

        return response()->json($topup, 201);
    }

    public function transactions(Request $request){
        $user = $request->user();

        return response()->json($user->transactions, 200);
    } 
}