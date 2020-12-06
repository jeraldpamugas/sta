<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Transactionheaders;
use App\Models\Transactionlines;
use App\Models\Warehouses;
use App\Models\Useraccounts;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;

class StaApiController extends Controller
{
    //Items -> getItems, storeItem, getItem, destroyItem

    public function getItems()
    {
        if (Items::all()) {
            $items = Items::get()->toJson(JSON_PRETTY_PRINT);
            return response($items, 200);
        } else {
            return response()->json([
                "message" => "No Item record found!"
            ], 404);
        }
    }

    public function storeItem(Request $request)
    {
        if(!$request->itemCode || !$request->Description || !$request->unit){
            return response()->json(['message'=>'Fillout all required fields.'], 202);
        }
        else{
            $item = Items::updateOrCreate(['id' => $request->id], [
                        'itemCode' => $request->itemCode,
                        'Description' => $request->Description,
                        'unit' => $request->unit
                    ]);
            return response()->json(['code'=>200, 'message'=>'Item Created successfully','data' => $item], 200);
        }
    }

    public function getItem($id)
    {
        if (Items::where('id', $id)->exists()) {
            $item = Items::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($item, 200);
        } else {
            return response()->json([
                "message" => "Item not found"
            ], 404);
        }
    }

    public function destroyItem($id)
    {
        if(Items::where('id', $id)->exists()) {
            $item = Items::find($id);
            $item->delete();

            return response()->json([
              "message" => "Item deleted"
            ], 202);
        }
        else {
            return response()->json([
                "message" => "Item not found"
            ], 404);
        }
    }

    //Warehouse -> getWarehouses, storeWarehouse, getWarehouse, destroyWarehouse

    public function getWarehouses()
    {
        if (Warehouses::all()) {
            $warehouses = Warehouses::get()->toJson(JSON_PRETTY_PRINT);
            return response($warehouses, 200);
        } else {
            return response()->json([
                "message" => "No Warehouse record found!"
            ], 404);
        }
    }

    public function storeWarehouse(Request $request)
    {
        if(!$request->warehouseCode || !$request->description){
            return response()->json(['message'=>'Fillout all required fields.'], 202);
        }
        else{
            $warehouse = Warehouses::updateOrCreate(['id' => $request->id], [
                        'warehouseCode' => $request->warehouseCode,
                        'Description' => $request->description
                    ]);

            return response()->json(['code'=>200, 'message'=>'Warehouse Created successfully','data' => $warehouse], 200);
        }
    }

    public function getWarehouse($id)
    {
        if (Warehouses::where('id', $id)->exists()) {
            $warehouse = Warehouses::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($warehouse, 200);
        } else {
            return response()->json([
                "message" => "Warehouse not found"
            ], 404);
        }
    }

    public function destroyWarehouse($id)
    {
        if(Warehouses::where('id', $id)->exists()) {
            $warehouse = Warehouses::find($id);
            $warehouse->delete();

            return response()->json([
              "message" => "Warehouse deleted"
            ], 202);
        }
        else {
        return response()->json([
            "message" => "Warehouse not found"
        ], 404);
        }
    }

    //Transactions -> getTransactions, storeTransaction, showTransaction, updateTransaction
    //Transactionslines -> getTransactionLines

    public function getTransactions()
    {
        $transactions = Transactionheaders::get()->toJson(JSON_PRETTY_PRINT);
        return response($transactions, 200);
    }

    public function getTransactionsToday()/////////////
    {
        $transactions = Transactionheaders::get()
        ->where('transferDate', '>=', date('Y-m-d').' 00:00:00')
        ->toJson(JSON_PRETTY_PRINT);
        if($transactions){
            return response($transactions, 200);
        }
        else{
            return response()->json([
                "message" => "No Transaction records found!"
            ], 404);
        }
    }

    public function getTransactionsByStatus($status)
    {
        $transactions = Transactionheaders::where('status', $status)
        ->get()->toJson(JSON_PRETTY_PRINT);

        $checkVal = json_decode($transactions, true);
        if(!empty($checkVal)){
            return response($transactions, 200);
        }
        else{
            return "No Transaction records found!";
        }
    }

    public function getTransactionsByStatus2($status1, $status2)
    {
        $transactions = Transactionheaders::where(
            'status', '=', $status1)
            ->orWhere('status', '=', $status2)
        ->get()->toJson(JSON_PRETTY_PRINT);
        
        $checkVal = json_decode($transactions, true);
        if(!empty($checkVal)){
            return response($transactions, 200);
        }
        else{
            return "No Transaction records found!";
        }
    }

    public function storeTransaction(Request $request)
    {
        if(!$request->warehouseFrom || !$request->warehouseTo || !$request->transferDate || !$request->reference){
            return response()->json(['message'=>'Fillout all required fields.'], 202);
        }
        else{

            $transaction = Transactionheaders::create($request->all());

            $itemCode;
            $itemQty;

            foreach($request->items as $item){

                $stringVal = explode('-', $item);
                $itemCode = $stringVal[0];
                $itemQty = $stringVal[1];

                $itemList = Items::select()->where('itemCode','=', $itemCode)->get();

                $tmp = new Transactionlines;
                $tmp->transNo = $request->transNo;
                $tmp->itemCode = $itemCode;
                $tmp->unit = $itemList[0]->unit;
                $tmp->quantity = $itemQty;
                $tmp->save();
            }

            return response()->json(['Success'=>'Transaction Created successfully'], 200);
        }
    }

    public function showTransaction($id)
    {
        if (Transactionheaders::where('id', $id)->exists()) {
            $trans = Transactionheaders::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($trans, 200);
        } 
        else {
            return response()->json([
                "message" => "Transaction not found!"
            ], 404);
        }
    }

    public function getTransactionLines($transNo)
    {
        if (Transactionlines::where('transNo', $transNo)->exists()) {
            $translinesList = Transactionlines::join('items', 'transactionlines.itemCode', '=', 'items.itemCode')
            ->where('transNo',$transNo)
            ->get(['items.Description', 'transactionlines.*'])->toJson(JSON_PRETTY_PRINT);
            return response($translinesList, 200);
        } 
        else {
            return response()->json([
                "message" => "Transactionline not found!"
            ], 404);
        }
    }

    public function updateTransaction(Request $request)
    {
        if(!$request->status){
            return 'Invalid Status';
        }
        else{
            $currentUser = session::get('code');
            $request->merge(['status' => $request->status]);
            $transHeader;

            if($request->status == 'A'){
                $transHeader = Transactionheaders::updateOrCreate(['id' => $request->id], [
                    'status' => $request->status,
                    'authorizedBy' => $currentUser,
                    'authorizedDate' => Carbon::now(),
                    'sysmodifier' => $currentUser
                ]);
            }
            else if($request->status == 'C'){
                $transHeader = Transactionheaders::updateOrCreate(['id' => $request->id], [
                    'status' => $request->status,
                    'confirmedBy' => $currentUser,
                    'confirmedDate' => Carbon::now(),
                    'sysmodifier' => $currentUser
                ]);
            }
            else if($request->status == 'P'){
                $transHeader = Transactionheaders::updateOrCreate(['id' => $request->id], [
                    'status' => $request->status,
                    'processedBy' => $currentUser,
                    'processedDate' => Carbon::now(),
                    'sysmodifier' => $currentUser
                ]);
            }
            else{
                return 'Invalid Status';
            }

            return response()->json(['code'=>200, 'success'=>'Transaction Created successfully','data' => $transHeader], 200);
        }
    }

    public function updateIsViewed($id,$isOpened)
    {
        if($isOpened == 0 || $isOpened == 1){
            // $transactions = Transactionheaders::where('id', $id)
            $transactions = Transactionheaders::updateOrCreate(['id' => $id], [
                'isOpened'=> $isOpened
            ]);
            
            $checkVal = json_decode($transactions, true);
            return response()->json(['code'=>200, 'success'=>'Transaction isOpened was updated!'], 200);
        }
        else{
            // $transHeader = Transactionheaders::updateOrCreate(['id' => $id], [
            //     'isOpened' => $isOpened
            // ]);
            return 'Invalid Value!';
        }
    }
}
