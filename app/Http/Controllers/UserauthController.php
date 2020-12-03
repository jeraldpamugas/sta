<?php

namespace App\Http\Controllers;

use App\Models\Useraccounts;
use Illuminate\Http\Request;

class UserauthController extends Controller
{
    public function userlogin(Request $req)
    {
        $data = $req->input();
        $users = Useraccounts::where([
            ['fullname', '=', $req->input('fullname')],
            ['code', '=', $req->input('usercode')]])->first();
        if (!$req->input('fullname') && !$req->input('usercode')){
            return redirect('/')
                            ->with('failed','Please input your Fullname and Usercode!');
        }
        else if (!$req->input('fullname')){
            return redirect('/')
                            ->with('failed','Please input your Fullname!');
        }
        else if (!$req->input('usercode')){
            return redirect('/')
                            ->with('failed','Please input your Usercode!');
        }
        else if ($users === null) {
            return redirect('/')
                            ->with('failed','Account didnt exist!');
        } 
        else {
            $userData = Useraccounts::select()->where('code','=', $data['usercode'])->get();
            foreach ($userData as $user)
                {
                    $req->session()->put('usertype',$user->usertype);
                }
            $req->session()->put('code',$data['usercode']);
            return redirect('home');
        }
    }
}
