<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\OrderDetail;
class OrderController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function savemenu(Request $request)
  {
    $order = Order::where(['userid'=> Auth::user()->id, 'isFinal' => '0'])->first();
    if($order){
      //update order
      // 'menuid':id,
      // 'qty':qty,
      // 'price':price

      $item = new OrderDetail;
      $item->orderid = $order->id;
      $item->menuitemsid = $request->menuid;
      $item->quantity = $request->qty;
      $item->amount = $request->price;
      $item->save();

    }else{
      //creates order
      //save orderdetails
      $c_order = new Order;
      $c_order->userid = Auth::user()->id;
      $c_order->isFinal = 0;
      $c_order->subtotal = ($request->qty * $request->price);
      $c_order->discount = 0;
      $c_order->couponcode = '';
      $c_order->total = ($request->qty * $request->price);
      $c_order->save();
      $orderid = $c_order->id;

      $item = new OrderDetail;
      $item->orderid = $orderid;
      $item->menuitemsid = $request->menuid;
      $item->quantity = $request->qty;
      $item->amount = $request->price;
      $item->save();

    }
    return response()->json($order);
  }
  public function viewfoodcart()
   {
     $order = Order::where(['userid'=> Auth::user()->id, 'isFinal' => '0'])->first();
     // dd($order);


     if($order){
         $oid = $order->id;
         // $latestPosts = DB::table('posts')
         //           ->select('user_id', DB::raw('MAX(created_at) as last_post_created_at'))
         //           ->where('is_published', true)
         //           ->groupBy('user_id');

 // menuitemsid->where('orderid',$oid)DB::raw('sum(quantity) as quantity'),
 // quantity->groupBy('menuitemsid')
 // amount  DB::raw('count(*) as user_count, status')
 // orderid  ->join('contacts', 'users.id', '=', 'contacts.user_id')
       $orderdetails = DB::table('order_details')
                         ->join('menuitems', 'order_details.menuitemsid', '=', 'menuitems.id')
                         ->select(DB::raw('sum(order_details.quantity) as quantity'),'order_details.orderid', 'order_details.menuitemsid', 'order_details.amount', 'menuitems.foodname')
                         ->where('order_details.orderid', $oid)
                         ->groupBy('menuitemsid')
                         ->get();
 // dd($orderdetails);
       return view('foodcart')->with('foods', $orderdetails);
     }else{
           return redirect('/home');
     }
   }
  public function delItem(Request $request)
  {
    //order_details -> delete
    $action = DB::table('order_details')->where(['orderid'=>$request->orderid,'menuitemsid'=>$request->menuid])->delete();
    return response()->json($action);
  }
  public function getCoupon(Request $request)
  {
    $coupon = DB::table('coupons')->where('code', $request->code)->get();
    return response()->json($coupon);
  }
  public function saveOrder(Request $request)
  {
    // "txtstotal" => "507"
    // "txtdiscval" => "50.70"
    // "couponcode" => "go2018"
    // "txttotal" => "456.30"
    // "button" => null

    $data = DB::table('orders')->where('id',$request->txtorderid)
              ->update(['subtotal'=>$request->txtstotal, 'discount'=>$request->txtdiscval,'total'=>$request->txttotal,'isFinal'=>1]);

    return redirect('/foodcart');
  }
  public function viewOrders(Request $request)
  {
    $orders = DB::table('orders')->where(['userid'=>Auth::user()->id,'isFinal'=>1])->get();
    // dd($orders);
    return view('orders')->with('orders', $orders);
  }
  public function viewOrderItems(Request $request)
  {
    $orderid = $request->id;
    $orders = DB::table('orders')->where('id',$orderid)->get();
    $orderdetails = DB::table('vwordersdetails')->where('orderid',$orderid)->get();
    return view('orderdetails')->with(['foods' => $orderdetails, 'orders'=> $orders]);
  }
}
