<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\QuestionsRequest;

use App\Models\question;
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



    public function index(Request $request)
    {
        $input = $request->all();
        if(isset($input['category_id'])){
            $questions = Question::where('category_id',$input['category_id'])
            ->orderBy('created_at','DESC')
            ->simplePaginate(15);
            $questions->load('category','user');
            $categorys = Category::select()->get();
            return view('questions.index',compact('questions','categorys'));
        }else{
            $questions = Question::select()
            ->orderBy('created_at','DESC')
            ->simplePaginate(15);
            $questions->load('category','user');
            $categorys = Category::select()->get();
            return view('questions.index',compact('questions','categorys'));
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
        $categorys = Category::get();
        return view('questions.create',compact('user','categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {   
        $question = new question;
        $question->fill($request->all());
        $image = $request->file('image');
        if($image){
            $fileName = $image->getClientOriginalExtension();
        }

        if($request->hasFile('image')){
            if($fileName=='jpg'){
                $path = \Storage::put('/public',$image);
                $path = explode('/',$path);
                $question->image = $path[1];
                $question->save();
            }elseif($fileName=='mp4'){
                $path = \Storage::put('/public',$image);
                $path = explode('/',$path);
                $question->video = $path[1];
                $question->save();
            }
        }else{
            $question->save();
        }
        
        return  redirect( route('question.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($question_id)
    {
        $questions = Question::where('user_id',\Auth::id())
        ->get();
        $asked_question = Question::find($question_id);
        $asked_question->load('category','user','answers.user');
        
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
        Question::where('id',$request['question_id'])->update( [ 'status' => $request['id'] ]);
        
        $asked_question = Question::find($request['question_id']);
        $asked_question->load('category','user','answers.user');
        
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
        $questions = Question::where('title','like',"%{$request->search}%")
        ->orwhere('content','like',"&{$request->search}%")
        ->simplePaginate(15);

        $search_result_message = $request->search.'の検索結果'.count($questions).'件';
        
        return view('questions.index',compact('questions','search_result_message'));
    }

    public function history()
    {
        $questions = Question::where('user_id',\Auth::id())
                    ->orderBy('created_at','DESC')
                    ->get();
        $questions->load('category');
        return view('questions.history',compact('questions'));
    }
}
