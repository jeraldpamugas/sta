<?php

namespace App\Http\Controllers;

use App\Models\Transactionheaders;
use App\Models\Warehouses;
use App\Models\Items;
use App\Models\Transactionlines;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $usertype = session::get('usertype');

        //get today and upcoming
        $requestToday = Request::create('api/transactionsToday', 'GET');
        $responseToday = app()->handle($requestToday);
        $transactionListToday = $responseToday->getContent();
        $transactionsToday = json_decode($transactionListToday);

        if($usertype == 'staff'){
            return view('home.index',compact('transactionsToday', 'usertype'));
        }
        else if($usertype == 'supervisor'){
            //get status O
            $requestO = Request::create('api/transactionsByStatus/O', 'GET');
            $responseO = app()->handle($requestO);
            $transactionListO = $responseO->getContent();

            //get status A
            $requestA = Request::create('api/transactionsByStatus/A', 'GET');
            $responseA = app()->handle($requestA);
            $transactionListA = $responseA->getContent();

            $transactions = json_decode($transactionListO);
            $transactionsCP = json_decode($transactionListA);
            // return $transactions;
            return view('home.index',compact('transactions', 'transactionsCP', 'transactionsToday', 'usertype'));
        }
        else if($usertype == 'manager'){

            //get status A
            $requestC = Request::create('api/transactionsByStatus/A/C', 'GET');
            $responseC = app()->handle($requestC);
            $transactionListC = $responseC->getContent();

            //get status B
            $requestP = Request::create('api/transactionsByStatus/C/P', 'GET');
            $responseP = app()->handle($requestP);
            $transactionListP = $responseP->getContent();
            
            $transactions = json_decode($transactionListC);
            $transactionsCP = json_decode($transactionListP);
            // return $transactions;
            return view('home.index',compact('transactions', 'transactionsCP', 'transactionsToday', 'usertype'));
        }
    }
}
