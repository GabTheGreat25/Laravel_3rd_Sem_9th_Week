<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
use Redirect;
use App\Models\Album;
use App\Models\Listener;
use App\DataTables\ListenersDataTable;

use DataTables;
use Yajra\DataTables\Html\Builder;

use App\Imports\ListenerImport;
use Excel;
use App\Rules\ExcelRule;

use App\Events\SendMail;
use Event;

class ListenerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $listeners = DB::table('listeners')
    //                     ->leftJoin('album_listener','listeners.id','=','album_listener.listener_id')
    //                     ->leftJoin('albums','albums.id','=','album_listener.album_id')
    //                     ->select('listeners.id','listeners.listener_name','albums.album_name')
    //                     ->get();
    // return View::make('listener.index',compact('listeners'));
    // }



    public function index(Request $request)
    {
        

        if (empty($request->get('search'))) {
             $listeners = Listener::with('albums')->get();


          
        }
        else {
$listeners = Listener::with(['albums' =>function($q) use($request){
              $q->where("album_name","LIKE", "%".$request->get('search')."%");
                }])->get();
             // $listeners = Listener::with(['albums' =>function($q) use($request){
             //  $q->where("album_name","LIKE", "%".$request->get('search')."%");
             //    }])->orWhere('listener_name',"LIKE", "%".$request->get('search')."%")->get();
        }

             // $listeners = Listener::whereHas('albums');

        //dd($listeners);
 $url = 'listener.index1';
       return View::make('listener.index',compact('listeners','url'));



}








    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $albums = Album::pluck('album_name','id');
        // return View::make('listener.create',compact('albums'));

               // $albums = Album::with('artist')->pluck('album_name','id');
        
        $albums = Album::with('artist')->get();
        // dd($albums);
        // foreach($albums as $album ) {
        //     dump($album->artist->artist_name);
        // }
        return View::make('listener.create',compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
    //     $input = $request->all();
    //     $listener = Listener::create($input);

    //   //  $input['Listener_name'] =>
    //     if($request->album_id) {
    //     foreach ($request->album_id as $album_id) {
    //         DB::table('album_listener')->insert(
    //             ['album_id' => $album_id, 
    //              'listener_id' => $listener->id]
    //             );
    //     }
    // }
    //     return Redirect::to('listener')->with('success','New Listener added!');





    //     // $listener = new Listener;
    //     // $listener->listener_name = $request->lname;
    //     // // $input['listener_name'] = $request->lname;
    //     // // $listener = Listener::create($input);
    //     // $listener->save();
    //     // if($request->album_id) {
    //     //     foreach ($request->album_id as $album_id) {
    //     //         DB::table('album_listener')->insert(
    //     //             ['album_id' => $album_id, 
    //     //              'listener_id' => $listener->id
    //     //             ]
    //     //             );



        $input = $request->all();
        // dd($request->album_id);
        $input['password'] = bcrypt($request->password);
        $listener = Listener::create($input);
        Event::dispatch(new SendMail($listener));

        if(!(empty($request->album_id))){
            foreach ($request->album_id as $album_id) {
        DB::table('album_listener')->insert(
                    ['album_id' => $album_id, 
                     'listener_id' => $listener->id]
                    );
                // dd($listener->albums());
                // $listener->albums()->attach($album_id);
            } //end foreach
        }
        return Redirect::route('listener.index')->with('success','listener created!');

        // $input = $request->all();
        //  //dd($request->all());
        // $input['password'] = bcrypt($request->password);
        // $listener = Listener::create($input);
        // Event::dispatch(new SendMail($listener));



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
        // $listeners = DB::table('listeners')
        //                 ->join('album_listener','listeners.id','=','album_listener.listener_id')
        //                 ->join('albums','albums.id','=','album_listener.album_id')
        //                 ->select('listeners.id','listeners.listener_name','albums.album_name','album_listener.album_id')
        //                 ->where('listeners.id',$id)
        //                 ->get();
                          //  

            $listener = Listener::find($id);
            $album_listener = DB::table('album_listener')
                            ->where('listener_id',$id)
                            ->pluck('album_id')
                            ->toArray();
                           // dd($album_listener);

             $albums = Album::pluck('album_name','id');
            return View::make('listener.edit',compact('albums','listener','album_listener'));
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
        $listener = Listener::find($id);
        $album_ids = $request->input('album_id');

        $listener->albums()->sync($album_ids);

        
    //     if(empty($album_ids)){
    //     DB::table('album_listener')->where('listener_id',$id)->delete();
    //     } else {    
    //         foreach($album_ids as $album_id) {
    //              DB::table('album_listener')->where('listener_id',$id)->delete();
    //     }

    //         foreach($album_ids as $album_id) {
    //             DB::table('album_listener')->insert(['album_id' => $album_id, 'listener_id' => $id]); 
    //     }
    // }
    //     $listener->update($request->all());
        return Redirect::route('listener.index')->with('success','listener updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $listener = Listener::find($id);
        DB::table('album_listener')->where('listener_id',$id)->delete();
        $listener->delete();
        return Redirect::route('listener.index')->with('success','Listener deleted!');






        //  $album = Album::find($id);
        // $album->listeners()->detach();
        // $album->delete();
        
        // return Redirect::route('album.index')->with('success','Album deleted!');
    }


    public function getListeners(ListenersDataTable $dataTable)
    {
        $albums = Album::with('artist')->get();
        // $listener = Listener::with('albums')->get();
        return $dataTable->render('listener.listeners', compact('albums'));
    }

    public function import(Request $request) {
        
         $request->validate([
        'listener_upload' => ['required', new ExcelRule($request->file('listener_upload'))],
        ]);
        // dd($request);
        Excel::import(new listenerImport, request()->file('listener_upload'));
        
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }
}
