@extends('layouts.header')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">回答</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comments.store')  }}" enctype="multipart/form-data">
                            @csrf
                        <input type="hidden" name='user_id' value="{{ Auth::id() }}">
                        <input type="hidden" name='question_id' value="{{ $question_id }}">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">内容</label>
                            <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" rows="5"　></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label">参考になる画像や動画を投稿しよう</label>
                            <input class="form-control" type="file" id="formFileMultiple"  multiple>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">回答をする</button>
                        </div>
                    </form>
                </div>    
            </div>    
        </div>    
    </div>    
</div>    


@endsection