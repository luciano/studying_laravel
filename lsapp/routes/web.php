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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/hello', function () {
//     return '<h1>Hello World</h1>';
// });

/*
// caminho para a pagina
// acessar a pasta 'pages' e o arquivo 'about.blame.php' -> return view('pages.about');
Route::get('/about', function() {
    // return view('pages.about'); // call the php file direct
    // it's better to create an controller.. create controllers with php artisan
    return view('pages.about');
});
*/

// insert dynamic values or parameters into the URL
// sample url: http://lsapp.dev/user/22/Luciano
Route::get('user/{id}/{name}', function($id, $name) {
    return 'This is user ' . $name . ' with an id of ' . $id;
});

// the best practice to routing pages is using controllers
// using the controller with the method we want
Route::get('/', 'PagesController@index');

Route::get('/about', 'PagesController@about');

Route::get('/services', 'PagesController@services');

// create automatically all the routes for the Controller automatically created with the Model
Route::resource('posts', 'PostsController');
Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
