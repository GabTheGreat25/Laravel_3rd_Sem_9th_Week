<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
// use App\Product;
use Session;
use App\Cart;
use App\Models\Order;
use Auth;
use DB;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Stock;
class ProductController extends Controller
{
    public function getIndex(){
       $products = Stock::with('item')->get();
    //    dd($products);
       return view('shop.index',compact('products'));
    }
    public function getAddToCart(Request $request , $id){
        $product = Item::find($id);
        $oldCart = Session::has('cart') ? $request->session()->get('cart'):null;
       $cart = new Cart($oldCart);
        $cart->add($product, $product->item_id);
        $request->session()->put('cart', $cart);
        Session::put('cart', $cart);
        $request->session()->save();
        return redirect()->route('product.index');
    }
    public function getCart() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }
    public function getSession(){
     Session::flush();
    }
    public function postCheckout(Request $request){
        if (!Session::has('cart')) {
            return redirect()->route('product.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        // dd($cart);
        try {
            DB::beginTransaction();
            $order = new Order();
            $customer =  Customer::where('id',Auth::id())->first();
            // dd($cart->items);
         // $customer->orders()->save($order);
            $order->customer_id = $customer->id;
            // $order->date_placed = now();
            // $order->date_shipped = now(); //Carbon::now()->addDays(5);
            // $order->shipvia = $request->shipper_id;
            // $order->shipping = $request->shipping;
            $order->shipping = 10.00  ;
            $order->status = 'Processing';
            $order->save();
            // dd($cart->items);
         foreach($cart->items as $items){
         $id = $items['item']['item_id'];
                // dd($id);
                // DB::table('orderline')->insert(
                //     ['item_id' => $id, 
                //      'orderinfo_id' => $order->orderinfo_id,
                //      'quantity' => $items['qty']
                //     ]
                //     );
         $order->items()->attach($id,['quantity'=>$items['qty']]);
                $stock = Stock::find($id);
           $stock->quantity = $stock->quantity - $items['qty'];
          $stock->save();
            }
            // dd($order);
        }
        catch (\Exception $e) {
            dd($e);
         DB::rollback();
            // dd($order);
            return redirect()->route('product.shoppingCart')->with('error', $e->getMessage());
        }
        DB::commit();
        Session::forget('cart');
        return redirect()->route('product.index')->with('success','Successfully Purchased Your Products!!!');
    }
 public function getReduceByOne($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
         if (count($cart->items) > 0) {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }        
        return redirect()->route('product.shoppingCart');
    }
    public function getRemoveItem($id){
        $oldCard = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCard);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
         return redirect()->route('product.shoppingCart');
    }
}
