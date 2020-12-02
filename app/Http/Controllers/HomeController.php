<?php

namespace App\Http\Controllers;

use App\Models\Transactionheaders;
use App\Models\Warehouses;
use App\Models\Items;
use App\Models\Transactionlines;
use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{
    public function index()
    {
        $usertype = session::get('usertype');

        // $translinesList = Transactionlines::join('items', 'transactionlines.itemCode', '=', 'items.itemCode')
        // ->where('transNo',$transNo)
        // ->get(['items.Description', 'transactionlines.*'])->toJson(JSON_PRETTY_PRINT);
        
        $transactionListAll = Transactionheaders::get()->toJson(JSON_PRETTY_PRINT);

        // return response()->json(['message'=>'Post Created successfully', $responseBody], 200);
        if($usertype == 'staff'){
            return view('home.index',compact('transactionListSt', 'usertype'));
        }
        else if($usertype == 'supervisor'){
            $transactionList = Transactionheaders::where('status', 'O')
            ->get()->toJson(JSON_PRETTY_PRINT);
            return view('home.index',compact('transactionList', 'usertype'));
        }
        else if($usertype == 'manager'){
            $transactionList = Transactionheaders::where([
                ['status', '=', 'A'],
                ['status', '=', 'C']
            ])
            ->get()->toJson(JSON_PRETTY_PRINT);
            return view('home.index',compact('transactionList', 'usertype'));
        }
    }
}
