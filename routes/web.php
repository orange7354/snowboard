<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswersController;
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


// googleへのリダイレクト
Route::get('/login/google', [GoogleLoginController::class, 'redirectToGoogle']);
// 認証後にコールバックを受けるルート
Route::get('/login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
// ゲストログイン
Route::get('guest', [LoginController::class,'guestLogin'])->name('login.guest');

Route::get('/home',[QuestionController::class,'index'])->name('question.index');

Route::group(['middleware' => ['auth']], function() {
    // 質問投稿を作成ページに遷移し投稿する
    Route::get('/questions/create',[QuestionController::class,'create'])->name('question.create');
    Route::post('/questions',[QuestionController::class,'store'])->name('question.store');
    // 質問詳細ページに遷移
    Route::get('/question/{id}',[QuestionController::class,'show'])->name('question.show');
    // ベストアンサー
    Route::post('/answers/like',[QuestionController::class,'update'])->name('question.update');
    // 質問履歴表示
    Route::get('/myquestions',[QuestionController::class,'history'])->name('question.history');
});

Route::group(['middleware' => ['auth']], function() {
    // 回答投稿を作成ページに遷移し投稿する
    Route::get('/answers/create',[AnswersController::class,'create'])->name('answers.create');
    Route::post('/answers/store',[AnswersController::class,'store'])->name('answers.store');
});
Route::post('/questions/search',[QuestionController::class,'search'])->name('question.search');

Route::delete('/question/{id}',[QuestionController::class,'destroy'])->name('question.delete');