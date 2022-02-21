<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\QuestionsRequest;

use App\Models\Question;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        $data = \Request::query();
        if(isset($data['category_id'])){
            $questions = question::where('category_id',$data['category_id']) ->orderBy('updated_at','DESC')->simplePaginate(15);
            $questions->load('category','user');
            return view('questions.index',compact('questions'));
        }else{
            $questions = question::select('questions.*')
            ->orderBy('updated_at','DESC')
            ->simplePaginate(15);
            $questions->load('category','user');
            return view('questions.index',compact('questions'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        return view('questions.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {   
        $data = $request->all();
        $image = $request->file('image');
        if($image){
            $fileName = $image->getClientOriginalExtension();
        }

        
        if($request->hasFile('image')){
            if($fileName=='jpg'){
                $path = \Storage::put('/public',$image);
                $path = explode('/',$path);
                Question::insert(['title'=>$data['title'], 'content'=>$data['content'], 'category_id'=>$data['category_id'], 'user_id'=>\Auth::id(),
                'image'=>$path[1]]);
            }elseif($fileName=='mp4'){
                $path = \Storage::put('/public',$image);
                $path = explode('/',$path);
                Question::insert(['title'=>$data['title'], 'content'=>$data['content'], 'category_id'=>$data['category_id'], 'user_id'=>\Auth::id(),
                'video'=>$path[1]]);
            }
        }else{
            $path = null;
            Question::insert(['title'=>$data['title'], 'content'=>$data['content'], 'category_id'=>$data['category_id'], 'user_id'=>\Auth::id(),
            ]); 
        }
        
        return  redirect( route('question.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questions = question::select('questions.*')
        ->where('user_id',\Auth::id())
        ->orderBy('updated_at','DESC')
        ->get();
        $asked_question = Question::find($id);
        
        $asked_question->load('category','user','comments.user');
        
        
        return view('questions.show',compact('questions','asked_question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {
        $inputs = $request->all();
        Question::where('id',$inputs['question_id'])->update( [ 'status' => $inputs['id'] ]);
        
        $asked_question = Question::find($inputs['question_id']);
        $asked_question->load('category','user','comments.user');
        
        return view('questions.show', compact('asked_question'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $questions = question::where('title','like',"%{$request->search}%")
        ->orwhere('content','like',"&{$request->search}%")
        ->simplePaginate(15);

        $search_result = $request->search.'の検索結果'.count($questions).'件';
        
        return view('questions.index',compact('questions','search_result'));
    }

    public function history()
    {
        $questions = question::select('questions.*')
                    ->where('user_id',\Auth::id())
                    ->orderBy('updated_at','DESC')
                    ->get();
        $questions->load('category');
        return view('questions.history',compact('questions'));
    }
}
