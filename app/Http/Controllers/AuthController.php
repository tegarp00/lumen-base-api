<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

  public function login(Request $request)
  {
    $tocen = Hash::make('invitation');
    
    $admin = Admin::query()->where("email", $request->input("email"))->first();
    if($admin == null) {
      return response([
        "status" => false,
        "message" => "Email Not Found",
        "data" => []
      ], 404);
    }

    if(!Hash::check($request->input("password"), $admin->password)) {
      return response([
        "status" => false,
        "message" => "Invalid Password",
        "data" => []
      ], 404);
    }

    $request->session()->put('logged', true);
    $request->session()->put('dapp', 'invitation');

    return response([
      "status" => true,
      "message" => "Login Success",
      "data" => $admin,
      "token" => $tocen
    ], 200);
  }

  public function test()
  {
    return response([
      "status" => true,
      "message" => "token nice"
    ], 200);
  }
}
