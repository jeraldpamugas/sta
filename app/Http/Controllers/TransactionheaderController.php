<?php

namespace App\Http\Controllers;

use App\Models\Transactionheaders;
use App\Models\Warehouses;
use App\Models\Items;
use App\Models\Transactionlines;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;



class TransactionheaderController extends Controller
{
    
    public function index()
    {
        $usertype = session::get('usertype');

        // $transactions = Transactionheaders::latest()->paginate(5);
        // return $transactions;

        // return view('transactions.index',compact('transactions', 'usertype'))
        //     ->with('i', (request()->input('page', 1) - 1) * 5);

        
        $request = Request::create('api/transactions', 'GET');
        $response = app()->handle($request);
        $responseBody = $response->getContent();
        $transactions = json_decode($responseBody);
        
        return view('transactions.index',['transactions' => $transactions],compact('usertype'));
    }

    public function create()
    {
        $usertype = session::get('usertype');
        $itemList = Items::select()->get();
        $warehouseList = Warehouses::select('warehouseCode')->get();

        return view('transactions.create',compact('warehouseList', 'itemList', 'usertype'));
    }

    public function store(Request $request)
    {
        $transNewId = Transactionheaders::max('transNo') + 1;

        $request->validate([
            'transferDate' => 'required',
            'warehouseFrom' => 'required',
            'warehouseTo' => 'required',
            'reference' => 'required'
        ]);
        
        $transNewId = Transactionheaders::max('transNo') + 1;
    
        $currentUser = session::get('code');
        $request->merge(['employeeCode' => $currentUser]);
        $request->merge(['transNo' => $transNewId]);
        $request->merge(['syscreator' => $currentUser]);
        $request->merge(['sysmodifier' => $currentUser]);

        $req = Request::create('api/transactions', 'POST', $request->all());
        $response = app()->handle($req);
        $responseBody = $response->getContent();

        return response()->json(['message'=>'Post Created successfully', $responseBody], 200);
    }

    public function show(Transactionheaders $transaction)
    {
        $usertype = session::get('usertype');

        $statusVal;
        switch($transaction->status){
            case('O'):
                $statusVal = 'Opened';
                break;
            case('A'):
                $statusVal = 'Authorized';
                break;
            case('C'):
                $statusVal = 'Confirmed';
                break;
            case('P'):
                $statusVal = 'Processed';
                break;
        }

        //transaction
        $request = Request::create('api/transactions/' . $transaction->id, 'GET');
        $response = app()->handle($request);
        $responseBody = $response->getContent();
        $transaction = json_decode($responseBody, true);

        //transactionlines
        $request2 = Request::create('api/transactionlines/' . $transaction[0]['transNo'], 'GET');
        $response2 = app()->handle($request2);
        $responseBody2 = $response2->getContent();
        $translinesList = json_decode($responseBody2, true);
        
        return view('transactions.show',compact('transaction','translinesList','usertype','statusVal'));
    }

    public function edit(Transactionheaders $transaction)
    {
        $usertype = session::get('usertype');

        $itemList = Items::select()->get();
        $warehouseList = Warehouses::select('warehouseCode')->get();
        $translinesList = Transactionlines::select()
        ->where('transNo', $transaction->transNo)
        ->get();

        $updateIsOpend = Request::create('api/transactionsIsOpened/'.$transaction->id.'/1', 'PUT');
        $updateIsOpend2 = app()->handle($updateIsOpend);

        return view('transactions.edit',compact('transaction','translinesList','usertype', 'warehouseList', 'itemList'));
    }

    public function update(Request $request)
    {
        $request->merge(['status' => $request->status]);

        $req = Request::create('api/transactions', 'PUT', $request->all());
        $response = app()->handle($req);
        $responseBody = $response->getContent();
        
        if($responseBody == 'Invalid Status'){
            return 'Invalid Status';
        }
        else{
            $updateIsOpend = Request::create('api/transactionsIsOpened/'.$request->id.'/0', 'PUT');
            $updateIsOpend2 = app()->handle($updateIsOpend);

            return response()->json([$responseBody], 200);
        }
    }

}
