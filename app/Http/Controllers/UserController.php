<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Auth;
use App\Models\Order;
class UserController extends Controller
{
   public function __construct(){
        $this->total = 0;
    }
    public function getSignup(){
        return view('user.signup');
    }
    public function postSignup(Request $request){
        $this->validate($request, [
            'email' => 'email| required| unique:users',
            'password' => 'required| min:4'
        ]);
         $user = new User([
          'name' => $request->input('fname').' '.$request->lname,
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
         $user->save();
         $customer = new Customer;
         $customer->id = $user->id; //user_id
         $customer->fname = $request->fname;
         $customer->lname = $request->lname;
         $customer->addressline = $request->addressline;
         $customer->phone = $request->phone;
         $customer->zipcode = $request->zipcode;
         $customer->save();
         Auth::login($user);
         return redirect()->route('user.profile');
    }
   public function getSignin(){
        return view('user.signin');
    }
 public function getProfile(){
        $customer = Customer::where('id',Auth::id())->first();
        $orders = Order::with('customer','items')->where('customer_id',$customer->customer_id)->get();
        return view('user.profile',compact('orders'));
    }
    public function getLogout(){
        Auth::logout();
        return redirect()->guest('/');
    }
}