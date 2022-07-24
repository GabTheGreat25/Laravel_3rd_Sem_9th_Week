<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;

use View;
use Redirect;
use Validator;
use DB;

use App\DataTables\AlbumsDataTable;

use DataTables;
use Yajra\DataTables\Html\Builder;

use App\Imports\AlbumImport;
use App\Imports\AlbumArtistListenerImport;
use Excel;
use App\Rules\ExcelRule;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//     public function index()
//     {

//         //  $albums = ALbum::orderBy('id','DESC')->paginate(10); // without trash 
//         // // $album = Album::withTrashed()->orderBy('id','DESC')->paginate(10); // with trash to
//         // //dd($customers);
//         // return View::make('album.index', compact('albums'));

//        //  $albums = DB::table('albums')
//        //      ->join('artists','artists.id','albums.artist_id')
//        //      ->select('albums.id', 'artists.artist_name', 'albums.album_name','albums.img_path')->orderBy('albums.id', 'DESC')
//        //      ->get();
//        // // dd($artists);
//         // $albums = Album::all(); 
//         // //$albums = Album::with('artist')->get();
//         // return View::make('album.index',compact('albums'));




//         $albums = Album::with('artist','listeners')->get();
// // foreach ($albums as $album) {
// //             dump($album->album_name);
// //              dump($album->artist->artist_name); // this is lazy loaded
// //              foreach ($album->listeners as $listener) {
// //                  dump($listener->listener_name); 
// //                 }
// //         }
//         return View::make('album.index',compact('albums'));
//     }









    public function index(Request $request)
    {
        

        if (empty($request->get('search'))) {
            //$albums = Album::with('artist','listeners')->get();

            $albums = Album::all();
        }
else {
//             $albums = Album::with(['artist' =>function($q) use($request){
//               $q->where("artist_name","LIKE", "%".$request->get('search')."%");
//             }])->get();
// // $albums = Album::whereHas('artist', function($q) use($request){
//             //   $q->where("artist_name","LIKE", "%".$request->get('search')."%");
//             // })->get();
            $albums = Album::whereHas('artist', function($q) use($request) {
                    $q->where("artist_name","LIKE", "%".$request->get('search')."%");
 })->orWhereHas('listeners', function($q) use($request){
              $q->where("listener_name","LIKE", "%".$request->get('search')."%");
            })
            ->get();
// $albums = Album::whereHas('artist', function($q) use($request) {
            //         $q->where("artist_name","LIKE", "%".$request->get('search')."%");
            // })->orWhereHas('listeners', function($q) use($request){
            //   $q->where("listener_name","LIKE", "%".$request->get('search')."%");
            // })->orWhere('album_name',"LIKE", "%".$request->get('search')."%")
            // ->get();
        }

       $url = 'album.index1';
  return View::make('album.index',compact('albums','url'));

}
























    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artists = Artist::all();
        // dd($artists);
        return View::make('album.create',compact('artists'));


         $albums = Album::with('artist')->pluck('album_name','id');
        
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

     
        $request->validate([
            'image' => 'required|image' 
        ]);




        if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
            // $fileName = uniqid().'_'.$file->getClientOriginalName();
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path().'/images';
            // dd(public_path());
            $input['img_path'] = $fileName;
            
            $file->move($destinationPath,$fileName);
        }

       // Album::create($request->all());

                //dd($request);
        $artist = Artist::find($request->artist_id);
        // dd($artist);
        $album = new Album();
        $album->album_name = $request->album_name;
        // $album->artist_id = $artist->id;
         $album->genre = $request->genre;
         $album->year = $request->year;
         $album->img_path = $fileName; 
        $album->artist()->associate($artist);

        $album->save();
       
        return Redirect::to('/album')->with('success','New Album added!');




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

        // $album = Album::find($id);
        // $artists = Artist::pluck('artist_name','id');
        // // dd($artists);

         $album = Album::with('artist')->where('id',$id)->first();
        // $album = Album::with('artist')->find($id)->first();
        // $album = Album::with('artist')->where('id',$id)->take(1)->get();
        //dd($album);
        //$artist = Artist::where('id',$album->artist_id)->pluck('name','id');
        // dd($album);
        $artists = Artist::pluck('artist_name','id');
        // dd($artists);
        return View::make('album.edit',compact('album', 'artists'));
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
        // $album = Album::find($id);
        // $album->update($request->all());
        // return Redirect::to('/album')->with('success',' Album updated!');

        // $album = Album::find($id);
       //  // dd($album);
       //  $album->update($request->all());
       //  return Redirect::route('album.index')->with('success','Album updated!');

        $artist = Artist::find($request->artist_id);
        // dd($artist);
        $album = Album::find($id);
        // $album->artist_id = $request->artist_id;
        $album->album_name = $request->album_name;
        
        $album->artist()->associate($artist);
        $album->save();
        return Redirect::route('album.index')->with('success','Album updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Album::findOrFail($id)->delete();
        // $customer->delete();
        return Redirect::to('/album')->with('success',' Album deleted');
    }

     public function getAlbums(AlbumsDataTable $dataTable)
    {   
       
        $albums =  Album::with(['artist','listeners'])->get();
        // dd($albums);
        return $dataTable->render('album.albums');

    }

     public function import(Request $request) {
        
         $request->validate([
            'album_upload' => ['required', new ExcelRule($request->file('album_upload'))],
        ]);
        // dd($request);
        // Excel::import(new AlbumImport, request()->file('album_upload'));
         Excel::import(new AlbumArtistListenerImport, request()->file('album_upload'));
  return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }
}
