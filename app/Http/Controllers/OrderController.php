<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Call Model
use App\Models\User;

class OrderController extends Controller
{
    public function CheckUser(Request $request){
        $user = User::where('user_number', $request->user_number)->first();
        $data['name'] = $user['name'];
        $data['id'] = $user['id'];
        if($user)
            return response()->json(['error' => false, 'message' => 'Success', 'data' => $data], 200);
        return response()->json(['error' => true, 'message' => 'tidak ada data'], 200);
    }

    public function NewOrder(Request $request){
        return $request->all();
    }
}
