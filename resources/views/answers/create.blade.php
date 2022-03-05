@extends('layouts.header')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">回答</div>
                <div class="card-body">
                @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                @endif
                    <form method="POST" action="{{ route('answers.store')  }}" enctype="multipart/form-data">
                            @csrf
                        <input type="hidden" name='user_id' value="{{ Auth::id() }}">
                        <input type="hidden" name='question_id' value="{{ $question_id }}">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">内容</label>
                            <textarea name="answer" class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
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