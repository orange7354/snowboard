@extends('layouts.header')

@section('content')

<div class="card  mt-5 mb-5">
    <div class="card-header">
    カテゴリー: {{ $asked_question->category->category_name }}
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ $asked_question['title'] }}</h5>
        <p class="card-text">{{ $asked_question['content'] }}</p>
        <div class="text-center">
            <img src="{{ '/storage/'.$asked_question['image'] }}" class=" img-responsive center-block;" alt="Responsive image" width="1000" height="500">
        </div>
        @if(Auth::user()->id !== $asked_question->user_id)
            <a href="{{ route('comments.create',['question_id' => $asked_question->id])}}" class="btn btn-primary">コメントする</a>
        @endif
    </div>
    <div class="card-footer text-muted">
        {{ $asked_question['updated_at'] }}
    </div>
</div>
@foreach($asked_question->comments as $comment)
    <div class="card mt-5 mb-5">
        <div class="card-body">
            <h5 class="card-title">回答者:{{ $comment->user->name}}</h5>
            <p class="card-text">{{ $comment->comment }}</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
@endforeach

@endsection
