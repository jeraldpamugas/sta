<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use App\Events\ItemsUpdated;
use Session;
use Ixudra\Curl\Facades\Curl;

class ItemController extends Controller
{

    public function index()
    {
        $usertype = session::get('usertype');

        $request = Request::create('api/items', 'GET');
        $response = app()->handle($request);
        $responseBody = $response->getContent();

        // $dataTaw = array( 
        //     'first_name'=>'john', 
        //     'last_name'=>'ce', 
        //     'email'=>'Test@gmail.com', 
        //     'password'=>'password1', 
        //     'password_confirmation'=>'password1' 
        // );
        
        // $dataLogin = array( 
        //     'emailOrUsername'=>'Test@gmail.com', 
        //     'password'=>'password1'
        // );
        
        // $apiURI = 'http://portal.virginiafood.com.ph/ent/api/register';

        // $ch = curl_init($apiURI);          // initializes a cURL session

        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataTaw));    // changes the cURL session behavior with options

        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Set-Cache: vA4vgfxhdYk4cvSzvEmb7HwvfG3pVcNW'));

        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $res = curl_exec($ch);       // executes the started cURL session

        // curl_close($ch);      // closes the cURL session and deletes the variable made by curl_init();

        // dd(json_decode($res, true));

        //--------------------------------------------------
        // Register

        // $response = Curl::to('http://portal.virginiafood.com.ph/ent/api/register')
        //     ->withHeader('Content-Type: application/json')
        //     ->withHeader('Accept: application/json')
        //     ->withHeader('Set-Cache: vA4vgfxhdYk4cvSzvEmb7HwvfG3pVcNW')
        //     ->withData( json_encode($dataTaw))
        //     ->post();
        // dd(json_decode($response));

        //--------------------------------------------------
        // Login

        // $response = Curl::to('http://portal.virginiafood.com.ph/ent/api/login')
        //     ->withHeader('Content-Type: application/json')
        //     ->withHeader('Accept: application/json')
        //     ->withHeader('Set-Cache: vA4vgfxhdYk4cvSzvEmb7HwvfG3pVcNW')
        //     ->withData( json_encode($dataLogin))
        //     ->post();
        // dd(json_decode($response));

        //--------------------------------------------------
        // Items

        // $res = Curl::to('http://portal.virginiafood.com.ph/ent/api/useraccounts')->get();
        // dd($res);

        return view('items.items',['items' => json_decode($responseBody)],compact('usertype'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'itemCode' => 'required',
            'Description' => 'required',
            'unit' => 'required'
        ]);
        
        $submitType;
        
        if($request->id){
            $submitType = 'update';
        }
        else{
            $submitType = 'add';
        }

        $req = Request::create('api/items', 'POST', $request->all());
        $response = app()->handle($req);
        $responseBody = $response->getContent();
        

        $latestItem = Items::latest()->first();
        $itemEvent = event(new ItemsUpdated($latestItem, $submitType));
        
        return ['code'=>200];
    }

    public function show(Items $item)
    {
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
