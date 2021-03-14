<?php

namespace App\Http\Controllers\v1\Rest;

use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|email:rfc,dns',
            'first_name' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return self::Response(400, null,
            $validator->errors()->first());

        //creating new user
        $user = new User();
        $user['first_name'] = $request['first_name'];
        $user['email'] = $request['email'];
        $user['password'] = Hash::make($request['password']);
        $user['access_token'] = Str::random(32);
        $user->save();

        //send email
        $to_name = $request['first_name'];
        $to_email = $request['email'];
        $data = array('name' => $request['first_name'], "body" => "You're just registered successfully.");
        Mail::send('emails.mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Registration message');
            $message->from('trouble2021sh@gmail.com', 'Congratulations!!!');
        });

        return self::Response(200, ['access_token' => $user['access_token']]);

    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email:rfc,dns|exists:users,email',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return self::Response(400, null,
            $validator->errors()->first());

        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user['password'])) {
            return self::Response(400, null,
                'wrong password');
        }

        return self::Response(200, ['access_token' => $user['access_token']]);
    }

    public function search(Request $request)
    {
        $rules = [
            'search' => '',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return self::Response(400, null,
            $validator->errors()->first());

        $sql = '%' . $request['search'] . '%';


        $goods = Goods::where('name', 'like', $sql);


        return self::Response(200, ['goods' => $goods->paginate(10)]);


    }
}
