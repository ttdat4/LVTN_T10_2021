<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{

    public function login(UserRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $data = DB::table('users_role')
                ->where('user_id', '=', $user->id)
                ->select('role_id')
                ->get();
            $role = $data[0]->role_id;
            $token = $user->createToken("Laravel password")->accessToken;

            // $token = $user->createToken('My Token', ['place-orders'])->accessToken;
            return response()->json(["token" => "$token", "role" => "$role","user" => Auth::user()], 200);
        }
        return response()->json(["message" => "Email hoặc mật khẩu không đúng!"], 404);
    }
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        
        $user->save();
        return response()->json(["message" => "Dang ky thanh cong"], 201);
    }
    public  function profile(Request $request)
    {
        return response()->json(["user" => Auth::guard('api')->user()], 200);
    }
    public function index()
    {
        return User::all();
    }
    public function find($id)
    {
        $find = User::find($id);
        if (!$find) {
            return response()->json(['message' => 'Không tìm thấy khách hàng cần tìm!'], 404);
        }
        return $find;
    }
}
