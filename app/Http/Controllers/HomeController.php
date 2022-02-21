<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');

    }


    public function myquestion()
    {
        $questions = question::select('questions.*')
                    ->where('user_id',\Auth::id())
                    ->orderBy('updated_at','DESC')
                    ->get();
        $questions->load('category');
        return view('questions.myquestion',compact('questions'));
    }

}
