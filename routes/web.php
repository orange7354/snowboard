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


Auth::routes();



Route::get('/login/google', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback']);

Route::get('guest', [App\Http\Controllers\Auth\LoginController::class,'guestLogin'])->name('login.guest');




Route::get('/title',[App\Http\Controllers\QuestionController::class,'index'])->name('question.index');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/question/create',[App\Http\Controllers\QuestionController::class,'create'])->name('question.create');
    Route::post('/question',[App\Http\Controllers\QuestionController::class,'store'])->name('question.store');
    Route::get('/question/{id}',[App\Http\Controllers\QuestionController::class,'show'])->name('question.show');
    
});

Route::post('/question/search',[App\Http\Controllers\QuestionController::class,'search'])->name('question.search');

Route::get('/myquestion',[App\Http\Controllers\QuestionController::class,'history'])->name('question.history');


Route::get('/comments/create',[App\Http\Controllers\CommentsController::class,'create'])->name('comments.create');
Route::post('/comments/store',[App\Http\Controllers\CommentsController::class,'store'])->name('comments.store');


Route::post('/comments',[App\Http\Controllers\QuestionController::class,'update'])->name('question.update');
