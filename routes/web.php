<?php
use Illuminate\Support\Facades\Auth;
use App\User;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', "UserController@register")->middleware('admin');
Route::post('/register', "UserController@postregister")->middleware('admin')->name('register');

Route::get('/login', "UserController@login")->middleware('guest')->name('login');
Route::post('/login', "UserController@postlogin")->middleware('guest')->name('login');
Route::get('/logout', "UserController@logout")->name('logout');

Route::group(['middleware' => ['auth']], function () {
  Route::group(['prefix' => 'home'], function(){
    Route::get('/add', 'InputController@get_home')->name('homeadd');
    Route::post('/add', 'InputController@post_home')->name('inserthome');
    Route::get('/view', 'InputController@get_home_view')->name('homeview');
    Route::get('/edit/{id}', 'InputController@get_home_edit');
    Route::post('/edit', 'InputController@post_home_edit')->name('insertedit');
    Route::post('/del', 'InputController@delete_source')->name('delsource');
  });
  Route::group(['prefix' => 'branch'], function(){
    Route::get('/', 'InputController@get_branch')->name('branch');
    Route::post('/', 'InputController@post_branch')->name('insertbranch');
    Route::post('/edit', 'InputController@edit_branch')->name('editbranch');
    Route::post('/del', 'InputController@delete_branch')->name('delbranch');
  });

  Route::get('/list', 'InputController@list_data')->name('list');
  Route::post('/find/branch', 'InputController@ajax_data');

  Route::group(['prefix' => 'electric'], function(){
    Route::get('/import_excel', 'ImportExcelController@index_electric')->name('eimport');
    Route::post('/import_excel/import', 'ImportExcelController@import_electric');

    Route::get('/export_excel', 'ExportExcelController@index_electric')->name('eexport');
    Route::post('/export_excel/export', 'ExportExcelController@export_electric');
  });
  Route::group(['prefix' => 'water'], function(){
    Route::get('/import_excel', 'ImportExcelController@index_water')->name('wimport');
    Route::post('/import_excel/import', 'ImportExcelController@import_water');

    Route::get('/export_excel', 'ExportExcelController@index_water')->name('wexport');
    Route::post('/export_excel/export', 'ExportExcelController@export_water');
  });

});
