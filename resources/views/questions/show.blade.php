@extends('layouts.header')

@section('content')

<div class="card  mt-5  mb-5">
    <div class="card-header">
        {{ $asked_question['title'] }}
    </div>
    <div class="card-body">
        <p class="card-text">{{ $asked_question['content'] }}</p>
        @if(isset($asked_question['video']))
            <video controls autoplay muted >
                <source src="{{ $asked_question->video }}" type="video/mp4" >
            </video>
        @elseif(isset($asked_question['image']))
            <div class="text-center">
                <img src="{{ $asked_question->image }}" class=" img-responsive center-block;" alt="Responsive image" width="1000" height="500">
            </div>
        @endif
    </div>
    <div class="card-footer text-muted">
        <!-- ログインしているユーザーと投稿したユーザーが違ったら名前を表示 -->
        @if(Auth::user()->id !== $asked_question->user_id)
            {{$asked_question->user->name}}さん
        @endif
        {{ $asked_question->category->category_name }}
        <small class="text-muted"><?php $updated_at = $asked_question['updated_at']; echo date('Y/m/d', strtotime($updated_at));?></small>
    </div>
    <!-- ログインしているユーザーと投稿したユーザーが違ったら回答できる -->
    @if(Auth::user()->id !== $asked_question->user_id)
        <a href="{{ route('answers.create',['question_id' => $asked_question->id])}}" class="btn btn-primary btn-lg btn-block">回答する</a>
    @endif
    <!-- ログインしているユーザーと投稿したユーザーが同じでベストアンサーを選んでいなかったら投稿を削除できる -->
    @if(Auth::user()->id == $asked_question->user_id and !isset($asked_question['status']))
        <form action="{{route('question.delete',$asked_question->id)}}" method="POST" class="float-right">
            @csrf
            @method('delete')
            <div>
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    削除
                </button>
            </div>
        </form>
    @endif
</div>

<!-- statusカラムにanswer_idがあったらベストアンサーを表示 -->
@if(isset($asked_question['status']))
    @foreach($asked_question->answers as $answer)
        @if($asked_question['status'] === $answer['id'])
            <div class="card border-info mb-3">
                <div class="card-header">
                ベストアンサー: {{ $answer->user->name}}さん
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $answer->answer }}</p>
                </div>
            </div>
        @else
            <div class="card mt-5 mb-5">
                <div class="card-header">
                    {{ $answer->user->name}}さん
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $answer->answer }}</p>
                </div>
            </div>
        @endif
    @endforeach
@else
    @foreach($asked_question->answers as $answer)
        <div class="card mt-5 mb-5">
            <div class="card-header">
                {{ $answer->user->name}}さん
            </div>
            <div class="card-body">
                <p class="card-text">{{ $answer->answer }}</p>
                <!-- ログインしているユーザーと投稿したユーザーが同じならベストアンサーを選択できる -->
                @if(Auth::user()->id === $asked_question->user_id)
                    <form  method="POST" action="{{ route('question.update')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name='question_id' value="{{ $asked_question['id'] }}">
                        <input type="hidden" name='id' value="{{ $answer['id'] }}">
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                ベストアンサーに選ぶ
                            </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ベストアンサー</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        変更はできませんが大丈夫ですか？
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">OK!</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
@endif

@endsection
