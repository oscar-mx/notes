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

Route::get('/', function () {
    return view('welcome');
});
use App\Models\Article;

Route::get('search', function () {
    dump(Article::all()->toArray());
    dump('搜索关键字为:laravel框架；内容如下:');
    dump(Article::search('laravel')->get()->toArray());
});