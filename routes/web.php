<?php

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

use App\City;
use App\Image;
use App\Product;
use App\Role;
use App\State;
use App\Tag;
use App\User;
use App\Country;
use Illuminate\Support\Facades\Auth;

Route::get('role-test',function (){
    $role= Role::find(2);
    return $role->users ;
});
Route::get('test_email',function (){
    return 'hello';
})->middleware(['auth','user_is_support','user_is_admin']);
Route::get('/', function () {
    return view('welcome');
});

Route::group(['auth','user_is_admin'],function (){
    Route::get('units','UnitController@index')->middleware(['auth','user_is_admin']);
    Route::post('units','UnitController@store')->name('units')->middleware(['auth','user_is_admin']);
    Route::delete('units','UnitController@delete')->middleware(['auth','user_is_admin']);
    Route::put('units','UnitController@update')->middleware(['auth','user_is_admin']);
    Route::get('search-units','UnitController@search')->name('search-units')->middleware(['auth','user_is_admin']);
    Route::get('add-unit','UnitController@showAdd')->name('new-unit')->middleware(['auth','user_is_admin']);


    Route::get('categories','CategoryController@index')->name('categories')->middleware(['auth','user_is_admin']);
    Route::post('categories','CategoryController@store')->middleware(['auth','user_is_admin']);
    Route::delete('categories','CategoryController@delete')->middleware(['auth','user_is_admin']);
    Route::put('categories','CategoryController@update')->middleware(['auth','user_is_admin']);
    Route::get('search categories','CategoryController@search')->name('search-categories')->middleware(['auth','user_is_admin']);


    Route::get('tags','TagController@index')->middleware(['auth','user_is_admin']);
    Route::post('tags','TagController@store')->name('tags')->middleware(['auth','user_is_admin']);
    Route::get('search-tags','TagController@search')->name('search-tags')->middleware(['auth','user_is_admin']);
    Route::delete('tags','TagController@delete')->middleware(['auth','user_is_admin']);
    Route::put('tags','TagController@update')->middleware(['auth','user_is_admin']);


    Route::get('products','ProductController@index')->name('products')->middleware(['auth','user_is_admin']);
    Route::get('new-product','ProductController@newProduct')->name('new-product')->middleware(['auth','user_is_admin']);
    Route::post('new-product','ProductController@store')->middleware(['auth','user_is_admin']);

    Route::post('delete-image','ProductController@deleteImage')->name('delete-image')->middleware(['auth','user_is_admin']);

    Route::get('update-product/{id}','ProductController@newProduct')->name('update-product-form')->middleware(['auth','user_is_admin']);
    Route::put('update-product','ProductController@update')->name('update-product')->middleware(['auth','user_is_admin']);
    Route::delete('products/{id}','ProductController@delete')->middleware(['auth','user_is_admin']);


    Route::get('countries','CountryController@index')->name('countries')->middleware(['auth','user_is_admin']);
    Route::post('countries','CountryController@store')->middleware(['auth','user_is_admin']);
    Route::get('search-countries','CountryController@search')->name('search-countries')->middleware(['auth','user_is_admin']);
    Route::delete('countries','CountryController@delete')->middleware(['auth','user_is_admin']);
    Route::put('countries','CountryController@update')->middleware(['auth','user_is_admin']);


    Route::get('cities','CityController@index')->name('cities')->middleware(['auth','user_is_admin']);
   // Route::post('cities','CityController@store')->middleware(['auth','user_is_admin']);
    //Route::get('cities','CityController@search')->name('search-cities')->middleware(['auth','user_is_admin']);
    //Route::delete('cities','CityController@delete')->middleware(['auth','user_is_admin']);
    //Route::put('cities','CityController@update')->middleware(['auth','user_is_admin']);


    Route::get('states','StateController@index')->name('states')->middleware(['auth','user_is_admin']);
    Route::get('reviews','ReviewController@index')->name('reviews')->middleware(['auth','user_is_admin']);
    Route::get('tickets','TicketController@index')->name('tickets')->middleware(['auth','user_is_admin']);



    Route::get('roles','RoleController@index')->middleware(['auth','user_is_admin']);
    Route::post('roles','RoleController@store')->name('roles')->middleware(['auth','user_is_admin']);
    Route::get('search-roles','RoleController@search')->name('search-roles')->middleware(['auth','user_is_admin']);
    Route::delete('roles','RoleController@delete')->middleware(['auth','user_is_admin']);
    Route::put('roles','RoleController@update')->middleware(['auth','user_is_admin']);

});













Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
