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



    public function index(Request $request)
    {
        //$requestの中にcategor_idの値があればカテゴリー検索しhomeページに遷移する
        if(isset($request['category_id'])){
            $questions = Question::where('category_id',$request['category_id'])
            ->orderBy('created_at','DESC')
            ->simplePaginate(15);
            $questions->load('category','user');
            $categorys = Category::select()->get();
        }else{
            $questions = Question::orderBy('created_at','DESC')
            ->simplePaginate(15);
            $questions->load('category','user');
            $categorys = Category::select()->get(); 
        }
        return view('questions.index',compact('questions','categorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 質問投稿ページに遷移する際にuser情報とカテゴリーの値を渡す。
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
        // ファイルがあれば、取得した拡張子を保存先をカラム別で分けてDBに保存
        if($request->hasFile('image')){
            // 取得した拡張子が'jpg'のときimageカラムに保存
            if($fileName=='jpg'){
                $path = Storage::disk('s3')->put('/image',$image,'public');
                $question->image = Storage::disk('s3')->url($path);
            // // 取得した拡張子が'mp4'のときvideoカラムに保存
            }elseif($fileName=='mp4'){
                $path = Storage::disk('s3')->put('/video',$image,'public');
                $question->video = Storage::disk('s3')->url($path);
            }
        }
        $question->save();
            
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
        // 質問詳細ページに遷移する際に$question_idを受け取りDB検索する
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
        // 質問詳細ページからquestion_idとanswer_idを受け取り、questionテーブルのstatusカラムにanswer_idを保存
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
    public function destroy($question_id)
    {
        $question = Question::find($question_id);
        $question->delete();
        return redirect()->route('question.index');
    }

    public function search(Request $request)
    {
        // 検索フォームで入力された値を$request->searchで取得し部分一致で一致する投稿の抽出
        $questions = Question::where('title','like',"%{$request->search}%")
        ->orwhere('content','like',"&{$request->search}%")
        ->simplePaginate(15);
        // 検索した結果の件数表示
        $search_result_message = $request->search.'の検索結果'.count($questions).'件';
        $categorys = Category::get();
        
        return view('questions.index',compact('questions','search_result_message','categorys'));
    }

    public function history()
    {
        // ログインしているユーザーの質問履歴取得しviewへ送る
        $questions = Question::where('user_id',\Auth::id())
                    ->orderBy('created_at','DESC')
                    ->get();
        $questions->load('category');
        return view('questions.history',compact('questions'));
    }
}
