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

Auth::routes();

Route::get('/', 'BlogController@index')->name('blog.index');
Route::get('/article/{article}', 'BlogController@showArticle')->name('blog.article');
Route::post('/comment/{article}', 'BlogController@comment')->name('blog.comment');

Route::middleware(['auth'])->group(function () {
	Route::prefix('admin')->group(function () {
		Route::resource('articles', 'ArticleController');
	});
});
