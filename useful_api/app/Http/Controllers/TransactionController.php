<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transfer(Request $request){
        $request->validate([
            'receiver_id' => ['exist:users,id'],
            'amount' => ['float']
        ]);

        
    } 
}