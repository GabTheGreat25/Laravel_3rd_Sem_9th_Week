<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use View;
use Redirect;
use Validator;
use softDeletes;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $customers = Customer::orderBy('lname','DESC')->get();
        //$customers = Customer::orderBy('id','DESC')->paginate(10); / without trash 
        //dd($customers);

        $customers = Customer::withTrashed()->orderBy('id','DESC')->paginate(10); // with trash to
        //dd($customers);
        return View::make('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return View::make('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), Customer::$rules, Customer::$messages);

        if ($validator->passes()) {
            Customer::create($request->all());
            return Redirect::to('customer')->with('success','New customer added!');
        }

        return redirect()->back()->withInput()->withErrors($validator);
        // Customer::create($request->all());
        // return Redirect::to('customer')->with('success','New Customer added!');
        // // protected $guarded = ['id'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $customer = Customer::find($id);
        //dd(compact('customer'));
        return View::make('customer.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      

        $customer = Customer::find($id);
        $validator = Validator::make($request->all(), Customer::$rules, Customer::$messages);

        if ($validator->fails()) {
           return redirect()->back()->withInput()->withErrors($validator);
        }

        $customer->update($request->all());
        
        return Redirect::to('customer')->with('success','Customer Updated!');


        // $customer = Customer::find($id);
     
        // $customer->update($request->all());
        
        // return Redirect::to('customer')->with('success','customer updated!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $customer = Customer::findOrFail($id)->delete();
        // $customer->delete();
        return Redirect::to('/customer')->with('success',' customer deleted');
    }

    public function restore($id) 
    {
        Customer::withTrashed()->where('id',$id)->restore();
        return  Redirect::route('customer.index')->with('success','Customer restored successfully!');
    }
}
