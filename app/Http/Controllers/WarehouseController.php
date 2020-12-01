<?php

namespace App\Http\Controllers;

use App\Models\Warehouses;
use Illuminate\Http\Request;
use Session;

class WarehouseController extends Controller
{

    public function index()
    {
        $usertype = session::get('usertype');

        $request = Request::create('api/warehouses', 'GET');
        $response = app()->handle($request);
        $responseBody = $response->getContent();

        return view('warehouses.warehouses',['warehouses' => json_decode($responseBody)],compact('usertype'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouseCode' => 'required',
            'description' => 'required'
        ]);
        $req = Request::create('api/warehouses', 'POST', $request->all());
        $response = app()->handle($req);
        $responseBody = $response->getContent();

        return response()->json(['code'=>200, 'message'=>'Warehouse saved successfully','data' => $responseBody], 200);
    }

    public function show(Warehouses $warehouse)
    {
        $request = Request::create('api/warehouses/' . $warehouse->id, 'GET');
        $response = app()->handle($request);
        $responseBody = $response->getContent();
        
        return response()->json($responseBody);
    }

    public function destroy(Warehouses $warehouse)
    {
        $request = Request::create('api/warehouses/' . $warehouse->id, 'DELETE');
        $response = app()->handle($request);
        $responseBody = $response->getContent();

        return response()->json(['success'=>'Item: '. $warehouse->warehouseCode .' Deleted successfully']);
    }
}
