<?php

namespace App\Http\Controllers\v1\Rest;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function makeOrder(Request $request)
    {
        $rules = [
            'goodsIds' => 'array|required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return self::Response(400, null,
            $validator->errors()->first());

        $user = $request['user'];

        foreach ($request['goodsIds'] as $goods) {
            $order = new Order();
            $order['user_id'] = $user['id'];
            $order['goods_id'] = $goods;
            $order->save();
        }

        //send email
        $to_name = $user['first_name'];
        $to_email = $user['email'];
        $data = array('name' => $user['first_name'], "body" => "your request is pending");
        Mail::send('emails.mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('About your request');
            $message->from('trouble2021sh@gmail.com', 'Congratulations!!!');
        });

        return self::Response(200,null,'your request is pending');

    }
}
