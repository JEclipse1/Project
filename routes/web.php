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
    return view('main');
});
// 구글 로그인
Route::get('/redirect', 'Auth\LoginController@redirect');
Route::get('/callback', 'Auth\LoginController@callback');

Auth::routes(); // 로그인 , 회원가입

Route::get('/home', 'HomeController@index')->name('home');

Route::get('myArticles', 'BoardsController@myArticles');

Route::post('/comment','CommentController@writeComment');
Route::get('/comment/{id}','CommentController@deleteComment')->name('deleteComment');

Route::resource('attachments' , 'AttachmentsController')->only(['store' , 'destroy']);

// BoardsController 에 만든 것들을 사용하기 위해서 이거 작성..index,store 같은
Route::resource('boards','BoardsController');

// 장바구니 카트, 미구현
Route::get('/cart', function(){
  return view('cart.cart');
});

//다 쓰지 말고 2가지만 사용하고 싶으면..배열로 빼옴
//Route::resource('boards','BoardsController')->only(['store','destroy']);
Route::get('/logout' , function(){
  Auth::logout();
  return view('main');
});
