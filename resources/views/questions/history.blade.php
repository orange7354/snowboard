@extends('layouts.header')

@section('content')

<div class=" my-3 p-3 pt-5 bg-white rounded shadow-sm">
    <h1>質問履歴</h1>
    @foreach($questions as $question)
        <div class="card mb-5">
        @if(isset($question['status']))
            <span class="badge badge-success">解決済み</span>
        @else
            <span class="badge badge-danger">回答受付中</span>
        @endif            
            <div class="card-header">
                カテゴリー: 
                <a href="{{ route('question.index',['category_id' =>$question->category_id]) }}">{{ $question->category->category_name }}</a>
            </div>
            <div class="card-body">
                <h5 class="card-title"> {{ $question['title'] }}</h5>
                <p class="card-text">{{ $question['content']}}</p>
                <a href="{{ route('question.show',$question->id  )}}" class="btn btn-primary">詳細</a>
            </div>
            <div class="card-footer text-muted">
                {{ $question['created_at'] }}
            </div>
        </div>
    @endforeach

</div>

@endsection
