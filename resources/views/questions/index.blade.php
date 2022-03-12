<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>advance</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/album.css') }}" rel="stylesheet">
  </head>
  <body >
    <a id="skippy" class="sr-only sr-only-focusable" href="#content">
  <div class="container">
    <span class="skiplink-text">Skip to main content</span>
  </div>
</a>

<header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <!-- <a class="navbar-brand" href="#">Fixed navbar</a> -->
    <a class="navbar-brand" href="#">advance</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <!-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> -->
          <a class="nav-link" href="{{ route('question.index')}}">ホーム <span class="sr-only">（現在位置）</span></a>
        </li>
        <li class="nav-item">
          <!-- <a class="nav-link" href="#">Link</a> -->
          <a class="nav-link" href="{{ route('question.history') }}" action="GET">質問履歴</a>
        </li>
        @if(Route::has('login'))
            @auth
              <li class="nav-item">
                <a class="nav-link" href="#">{{ Auth::user()->name }}さん</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
              </li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            @else
              <a href="{{ route('login') }}" class="nav-link">ログイン</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="nav-link">登録する</a>
              @endif
            @endauth
        @endif
      </ul>
      <form class="form-inline mt-2 mt-md-0" action="{{ route('question.search') }}" method="POST">
        {{ csrf_field() }}
        <!-- <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search"> -->
        <input class="form-control mr-sm-2" type="text" placeholder="検索" aria-label="Search" name="search">
        <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> -->
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
      </form>
    </div>
  </nav>
</header>

<main role="main" >
  <div class="jumbotron">
    <h1 class="display-4">advance</h1>
    <p><strong>スキルアップを目指す人のためのQ&Aサイト</strong></p>
          <!-- <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p> -->
          <p class="text-black">スノーボードをより楽しむために「できない」を誰かが解決してくれます。</p>
          <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p> -->
          <p><a class="btn btn-primary btn-lg" href="{{ route('question.create') }}" method="GET" role="button">質問する &raquo;</a></p>
  </div>
  <div class="container mt-5">
    <div class="row">
      <div class=" col-md-10 pt-2  bg-white rounded shadow-sm">
          <!-- <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6> -->
          @isset($search_result_message)
            <h1>{{ $search_result_message }}</h1>
          @endisset
          <h6 class="border-bottom border-gray pb-1 mb-0">新着質問</h6>
          @foreach($questions as $question)
            <div class="media text-muted pt-3">
              <p class="media-body pb-2 mb-1 small lh-125 border-bottom border-gray">
                <strong class="text-gray-dark"> {{ $question->category->category_name }}</strong>
                <strong class="d-block text-primary"><a href="{{ route('question.show',$question->id ) }}">{{ $question['title'] }}</a></strong>
                <!-- Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. -->
                {{ $question->user->name }}さん 
                <small class="text-muted"><?php $created_at = $question['created_at']; echo date('Y/m/d', strtotime($created_at));?></small>
                @if(isset($question['status']))
                  <span class="badge badge-success">解決済み</span>
                @else
                  <span class="badge badge-danger">回答受付中</span>
                @endif
              </p>
            </div>
          @endforeach
          {{ $questions->links() }}
    </div>
    <aside class="col-md-2 blog-sidebar">
    <div class="card mt-3">
      <div class="card-header">
        カテゴリー
      </div>
      <ul class="list-group list-group">
            @foreach($categorys as $category)
              <li class="list-group-item"><a href="{{ route('question.index',['category_id'=>$category->id])}}">{{$category->category_name}}</a></li>
            @endforeach
      </ul>
    </div>
  </aside>
</main>

<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <!-- <a href="#">Back to top</a> -->
      <a href="#">トップに戻る</a>
    </p>
  </div>
</footer>
</html>