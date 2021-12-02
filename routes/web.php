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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/login/google', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/title',[App\Http\Controllers\HomeController::class,'title'])->name('title');

Route::get('/title',[App\Http\Controllers\QuestionController::class,'index'])->name('question.index');
Route::get('/question1',[App\Http\Controllers\QuestionController::class,'create'])->name('question.create');
Route::post('/question',[App\Http\Controllers\QuestionController::class,'store'])->name('question.store');
Route::get('/question/{id}',[App\Http\Controllers\QuestionController::class,'show'])->name('question.show');
Route::post('/question/search',[App\Http\Controllers\QuestionController::class,'search'])->name('question.search');

Route::get('/myquestion',[App\Http\Controllers\HomeController::class,'myquestion'])->name('myquestion');


Route::get('/comments',[App\Http\Controllers\CommentsController::class,'create'])->name('comments.create');
Route::post('/comments',[App\Http\Controllers\CommentsController::class,'store'])->name('comments.store');
