@extends('layouts.header')

@section('content')
<div class="container pt-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">質問をする</div>
                <div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('question.store')  }}" enctype="multipart/form-data">
                            @csrf
                        <input type="hidden" name='user_id' value="{{ $user['id'] }}">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">タイトル</label>
                            <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="タイトルを入力してください">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">内容</label>
                            <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                        </div>
                        <select class="custom-select" id="category" name="category_id" required>
                            <option value="">質問のカテゴリーを選んでください
                            </option>
                            @foreach($categorys as $category)
                                <option value={{$category->id}}>{{$category->category_name}}</option>
                            @endforeach
                        </select>   
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                            <input class="form-control" type="file" id="formFileMultiple" name="image"   multiple>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">質問をする</button>
                        </div>
                    </form>
                </div>    
            </div>    
        </div>    
    </div>    
</div>    
@endsection
