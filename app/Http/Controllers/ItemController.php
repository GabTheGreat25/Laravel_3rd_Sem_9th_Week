<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Item;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Stock;
use App\Cart;
use View;
use Redirect;
use Validator;
use DB;
use Carbon;
use Session;
use Auth;

class ItemController extends Controller
{
    public function Index(){
        $items = Item::all();
       // dd($items);
        return view('shop.index', compact('items'));
    }

    public function getCart() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function getAddToCart(Request $request , $id){
        $product = Item::find($id);
        $oldCart = Session::has('cart') ? $request->session()->get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->item_id);
        $request->session()->put('cart', $cart);
        Session::put('cart', $cart);
        $request->session()->save();
        dd(Session::all());

    }

    public function getRemoveItem($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
         return redirect()->route('item.shoppingCart');
    }


     public function reduceByOne($id){
        $this->items[$id]['qty']--;
        $this->items[$id]['price']-= $this->items[$id]['item']['sell_price'];
        $this->totalQty --;
        $this->totalPrice -= $this->items[$id]['item']['sell_price'];
        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }
    public function removeItem($id){
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }

    public function getReduceByOne($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
         if (count($cart->items) > 0) {
            Session::put('cart',$cart);
            Session::save();
        }else{
            Session::forget('cart');
        }        
        return redirect()->route('item.shoppingCart');
    }




    public function postCheckout(Request $request){

        dd($request->all());
        if (!Session::has('cart')) {
            return redirect()->route('item.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
         //dd($cart);
        try {
            DB::beginTransaction();
            $order = new Order();
            //dd($order);
             //$customer =  Customer::where('user_id',Auth::id())->first();
             //dd($customer);

            $customer = DB::table('Customer')->where('user_id', Auth::id())->first();
           // $customer = 5;
            //sdd($customer);
//dd($order);
             // $order->customer_id = $customer->customer_id;
             $order->customer_id = 5;
             //
            $order->date_placed = now();
            $order->date_shipped =now();
            // $order->shipvia = $request->shipper_id;
            // $order->shipping = $request->shipping;
            $order->shipvia = 1;
            $order->shipping = 10.00;
            $order->status = 'Processing';
            $order->save();
            //dd($order);
            foreach($cart->items as $items){
            $id = $items['item']['item_id'];
                // dd($id);
                DB::table('orderline')->insert(
                    ['item_id' => $id, 
                     'orderinfo_id' => $order->orderinfo_id,
                     'quantity' => $items['qty']
                    ]

                    );

                  
                $stock = Stock::find($id);
              
                 
               $stock->quantity = $stock->quantity - $items['qty'];
              


               $stock->save();
                

               
            }
            // dd($order);
        }
catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            // dd($order);
            return redirect()->route('item.shoppingCart')->with('error', $e->getMessage());
        }
DB::commit();
        Session::forget('cart');
        return redirect()->route('Item.index')->with('success','Successfully Purchased Your Products!!!');
    }
}
