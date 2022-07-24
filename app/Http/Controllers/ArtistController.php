<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Album;
use App\DataTables\ArtistsDataTable;

use View;
use Redirect;
use Validator;
use DB;
use DataTables;
use Yajra\DataTables\Html\Builder;

//! Import and excel (week 6)

use App\Imports\ArtistImport;
use Excel;


class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    // //      $artists = Artist::all();
    // //     return View::make('artist.index',compact('artists'));


    //    //  $artists = DB::table('artists')->join('albums','artists.id','albums.artist_id')->select('albums.artists_id')->get();
    //    // // dd($artists);
    //    //  return View::make('artist.index',compact('artists'));

    //     // $artists = DB::table('artists')
    //     //     ->leftJoin('albums','artists.id','albums.artist_id')
    //     //     ->select('artists.id', 'artists.artist_name', 'albums.album_name','artists.img_path')->orderBy('artists.id', 'DESC')
    //     //     ->get();


    //     // $artists = Artist::all();
    //     $artists = Artist::with('albums')->get();
    //     //dd($artists);
    //     // foreach($artists as $artist)
    //     // {
    //     // foreach ($artist->albums as $album)
    //     // {
    //     //     dump($album->album_name);
    //     // }

    //     // }
    //      return View::make('artist.index',compact('artists'));

    // }



    public function index(Request $request)
    {


 if (empty($request->get('search'))) {
            // $artists = Artist::with('albums')->get();
            $artists = Artist::has('albums')->get();
            //dd($artists);
        }
        else 

            //dd($request);
        $artists = Artist::with(['albums'=> function($q) use($request){
              $q->Where("genre","=",$request->get('search'))
              ->orWhere("album_name","LIKE", "%".$request->get('search')."%");
            }])->get();
return View::make('artist.index',compact('artists'));

}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('artist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), Artist::$rules);

        if ($validator->fails()) {
           return redirect()->back()->withInput()->withErrors($validator);
        }



        $input = $request->all();
        if($request->hasFile('image')) {
            
            $file = $request->file('image') ;
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            // $fileName = $file->getClientOriginalName();
            // dd($fileName);
            $request->image->storeAs('images', $fileName, 'public');
            $input['img_path'] = $fileName;
            $artist = Artist::create($input);
           
        }


        //Artist::create($request->all());
            return Redirect::to('artist')->with('success','New artist added!');
           } 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = Artist::find($id);
         dd($artist);
        return view('artist.show',compact('artist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $artist = Artist::find($id);
        // dd($artist);
        return View::make('artist.edit',compact('artist'));
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
        $artist = Artist::find($id);
    
        $artist->update($request->all());
        return Redirect::to('/artist')->with('success','Artist updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $artist = Artist::find($id);
        $artist->albums()->delete();

        $artist->delete();
        $artists = Artist::with('albums')->get();
        
        
        return View::make('artist.index',compact('artists'));
    }

    
    public function getArtists(Builder $builder) {
        // dd($dataTable);
        // return $dataTable->render('artist.artists');
        // dd(Artist::orderBy('artist_name', 'DESC')->get());
        // $artists = Artist::orderBy('artist_name', 'ASC')->get();
        // dd($artists);
        $artist = Artist::query();
        // dd($artist);
        if (request()->ajax()) {
            // return DataTables::of($artists)
            //                 ->toJson();
            // return DataTables:
 //                 ->toJson();
            // return DataTables::of($artist)->order(function ($query) {
            //          $query->orderBy('artist_name', 'DESC');
            //      })->toJson();
                        // ->make();
 return DataTables::of($artist)->order(function ($query) {
                     $query->orderBy('artist_name', 'DESC');
                 })->addColumn('action', function($row) {
                    return "<a href=".route('artist.edit', $row->id). "
class=\"btn btn-warning\">Edit</a> <form action=". route('artist.destroy', $row->id). " method= \"POST\" >". csrf_field() .
                    '<input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                      </form>';
            })
                    ->rawColumns(['action'])
                    ->toJson();
        }

        $html = $builder->columns([
                ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
                ['data' => 'artist_name', 'name' => 'artist_name', 'title' => 'Name'],
['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],
                ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At'],
                ['data' => 'action', 'name' => 'action', 'title' => 'Action'],
            ]);

    return view('artist.artists', compact('html'));
}

public function store1(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $input['img_path'] = 'image.png';
        Artist::create($input);

        return Redirect::to('artists');
    }

    public function import(Request $request) {
        //! Import function for import
    //      $request->validate([
    //     'artist_upload' => ['required', new ExcelRule($request->file('artist_upload'))],
    // ]);
 // dd($request);
        Excel::import(new ArtistImport, request()->file('artist_upload'));
        // $input['img_path'] = 'image.png';
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }
}
