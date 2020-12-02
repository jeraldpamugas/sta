<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Session;

class ItemController extends Controller
{

    public function index()
    {
        $usertype = session::get('usertype');

        $request = Request::create('api/items', 'GET');
        $response = app()->handle($request);
        $responseBody = $response->getContent();

        return view('items.items',['items' => json_decode($responseBody)],compact('usertype'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'itemCode' => 'required',
            'Description' => 'required',
            'unit' => 'required'
        ]);
        $req = Request::create('api/items', 'POST', $request->all());
        $response = app()->handle($req);
        $responseBody = $response->getContent();

        return response()->json(['code'=>200, 'message'=>'Post Created successfully','data' => $responseBody], 200);
    }

    public function show(Items $item)
    {
        // $request = Request::create('api/items/' . $item->id, 'GET');
        $request = Request::create('api/items/' . $item->id, 'GET');
        $response = app()->handle($request);
        $responseBody = $response->getContent();
        
        return response()->json($responseBody);
    }

    public function destroy(Items $item)
    {
        $request = Request::create('api/items/' . $item->id, 'DELETE');
        $response = app()->handle($request);
        $responseBody = $response->getContent();

        return response()->json(['success'=>'Item: '. $item->itemCode .' Deleted successfully']);
    }
}
