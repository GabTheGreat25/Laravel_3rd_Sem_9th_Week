<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/hatdog', function () {
//     return view('prac');
// });


// Route::get('/customer/restore/{id}','Customercontroller@restore')->name('customer.restore');
// Route::resource('album','AlbumController')->middleware('auth');
// Route::resource('customer','CustomerController')->middleware('auth');
// Route::resource('artist','ArtistController')->middleware('auth');
// Route::resource('listener','ListenerController')->middleware('auth');

//Route::resource('customer','CustomerController');






Route::group(['middleware' => ['auth']], function () { 
    Route::get('/customer/restore/{id}','CustomerController@restore')->name('customer.restore');
    Route::resource('customer','CustomerController');
    Route::resource('album','AlbumController');
   
    

});
 Route::resource('album','AlbumController');
   
 Route::resource('artist','ArtistController');
 Route::resource('listener','ListenerController');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


  Route::get('/', [
      'uses' => 'ItemController@Index',
            'as' => 'Item.index1'
    ]);


    Route::get('/index', [
      'uses' => 'ItemController@Index',
            'as' => 'Item.index'
    ]);

    Route::get('/signup', [
        'uses' => 'userController@getSignup',
        'as' => 'user.signup',
        'middleware' => 'guest'
    ]);
    Route::post('/signup', [
        'uses' => 'userController@postSignup',
        'as' => 'user.signup1',
        'middleware' => 'guest'
    ]);

    Route::get('profile', [
        'uses' => 'UserController@getProfile',
        'as' => 'user.profile',
    ]);

    Route::get('/signin', [
        'uses' => 'userController@getSignin',
        'as' => 'user.signin;'
        
    ]);

    Route::post('/signin', [
        'uses' => 'userController@postSignin',
        'as' => 'user.signin1'
        
    ]);

    Route::get('logout', [
        'uses' => 'userController@getLogout',
        'as' => 'user.logout'
        
    ]);
        

    Route::get('shopping-cart', [
    'uses' => 'ItemController@getCart',
    'as' => 'item.shoppingCart'
    ]);

    Route::get('checkout',[
        'uses' => 'ItemController@postCheckout',
        'as' => 'checkout',
        'middleware' =>'auth'
    ]);

    Route::get('add-to-cart/{id}',[
        'uses' => 'ItemController@getAddToCart',
        'as' => 'item.addToCart'
    ]);


    Route::get('remove/{id}',[
        'uses'=>'itemController@getRemoveItem',
        'as' => 'item.remove'
    ]);

    Route::get('reduce/{id}',[
        'uses' => 'ItemController@getReduceByOne',
        'as' => 'item.reduceByOne'
    ]);


    Route::get('/listener/{search?}', [
      'uses' => 'ListenerController@index',
       'as' => 'listener.index1'
    ]);
Route::get('/artist/{search?}', [
      'uses' => 'ArtistController@index',
       'as' => 'artist.index1'
    ]);
Route::get('/album/{search?}', [
      'uses' => 'AlbumController@index',
       'as' => 'album.index1'
    ]);
Route::resource('artist', 'ArtistController')->except(['index']);
Route::resource('album', 'AlbumController')->except(['index']);
Route::resource('listener', 'ListenerController')->except(['index']);


Route::get('/show-album/{id}', [
      'uses' => 'AlbumController@show',
       'as' => 'getAlbum'
    ]);
Route::get('/show-artist/{id}', [
      'uses' => 'ArtistController@show',
       'as' => 'getArtist'
    ]);



Route::get('/artists', [
      'uses' => 'ArtistController@getArtists',
       'as' => 'getArtists'
    ]);
Route::get('/search/{search?}',['uses' => 'SearchController@search','as' => 'search'] );
Route::resource('artist', 'ArtistController')->except(['index', 'show']);
Route::resource('album', 'AlbumController')->except(['index', 'show']);

Route::post('/artista', [
        'uses' => 'ArtistController@store1',
        'as' => 'artist.store1'
            ]);

Route::get('/listeners', [
      'uses' => 'ListenerController@getListeners',
       'as' => 'getListeners'
    ]);

Route::get('/albums', [
      'uses' => 'AlbumController@getAlbums',
       'as' => 'getAlbums'
    ]);

Route::post('/artist/import', 'ArtistController@import')->name('artistImport');

Route::post('/listener/import', 'ListenerController@import')->name('listenerImport');
Route::post('/album/import', 'AlbumController@import')->name('albumImport');

Route::post('/contact',['uses' => 'MailController@contact','as' => 'contact']);
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::group(['middleware' => ['auth', 'admin']], function () {
   
//    Route::get('/albums', [
//       'uses' => 'AlbumController@getAlbums',
//        'as' => 'getAlbums'
//     ]);
//    Route::get('/listeners', [
//       'uses' => 'ListenerController@getListeners',
//        'as' => 'getListeners'
//     ]);
//  });

 Auth::routes();

//  Route::group(['middleware' => ['auth']], function () {
// //   Route::resource('listener', 'ListenerController')->except(['index']);
// //   Route::resource('artist', 'ArtistController')->except(['index', 'show']);
// //   Route::resource('album', 'AlbumController')->except(['index', 'show']);
   
//  });


 Route::group(['middleware' => ['auth', 'role:admin']], function () {
   
   Route::get('/albums', [
      'uses' => 'AlbumController@getAlbums',
       'as' => 'getAlbums'
    ]);
   Route::get('/listeners', [
      'uses' => 'ListenerController@getListeners',
       'as' => 'getListeners'
    ]);
 Route::get('/dashboard', [
      'uses' => 'DashboardController@index',
       'as' => 'dashboard.index'
    ]);
 });

 Route::group(['middleware' => ['auth','role:editor,user']], function () {
  Route::get('/listener/{search?}', [
      'uses' => 'ListenerController@index',
       'as' => 'listener.index1'
    ]);
  Route::get('/artist/{search?}', [
        'uses' => 'ArtistController@index',
         'as' => 'artist.index1'
      ]);
  Route::get('/album/{search?}', [
        'uses' => 'AlbumController@index',
         'as' => 'album.index1'
      ]);
 Route::resource('listener', 'ListenerController')->except(['index']);
  Route::resource('artist', 'ArtistController')->except(['index', 'show']);
  Route::resource('album', 'AlbumController')->except(['index', 'show']);
   
 });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
