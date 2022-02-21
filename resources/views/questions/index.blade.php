<!doctype html>
<html lang="ja" >
  <head>
    <title>アルバムサンプル for Bootstrap · Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
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
    <a class="navbar-brand" href="#">Snowboard Q&A</a>
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
        <li class="nav-item">
          <!-- <a class="nav-link disabled" href="#">Disabled</a> -->
          <a  class="nav-link" href="{{ route('question.create') }}" method="GET" class="btn btn-primary my-2">質問する</a>
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
          <p　class="text-info">スノーボードをより楽しむために「できない」を誰かが解決してくれます。</p>
          <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p> -->
          <p><a class="btn btn-primary btn-lg" href="{{ route('question.create') }}" method="GET" role="button">質問する &raquo;</a></p>
  </div>
  <div class="container mt-5">
    <div class="row">
      <div class=" col-10 pt-2  bg-white rounded shadow-sm">
          <!-- <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6> -->
          @isset($search_result)
            <h1>{{ $search_result }}</h1>
          @endisset
          <h6 class="border-bottom border-gray pb-1 mb-0">新着質問</h6>
          @foreach($questions as $question)
            <div class="media text-muted pt-3">
              <p class="media-body pb-2 mb-1 small lh-125 border-bottom border-gray">
                <strong class="text-gray-dark"> {{ $question->category->category_name }}</strong>
                <strong class="d-block text-primary"><a href="{{ route('question.show',$question->id ) }}">{{ $question['title'] }}</a></strong>
                <!-- Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. -->
                {{ $question->user->name }}さん 
                <small class="text-muted"><?php $updated_at = $question['updated_at']; echo date('Y/m/d', strtotime($updated_at));?></small>
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
      <div class="col">
      <div class="card">
        <div class="card-header">
          タグ一覧
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="{{ route('question.index',['category_id'=>1])}}">ハーフパイプ</a></li>
          <li class="list-group-item"><a href="{{ route('question.index',['category_id'=>2])}}">フリーラン</a></li>
          <li class="list-group-item"><a href="{{ route('question.index',['category_id'=>3])}}">グラトリ</a></li>
          <li class="list-group-item"><a href="{{ route('question.index',['category_id'=>4])}}">キッカー</a></li>
          <li class="list-group-item"><a href="{{ route('question.index',['category_id'=>5])}}">ジブ</a></li>
          <li class="list-group-item"><a href="{{ route('question.index',['category_id'=>6])}}">その他</a></li>
        </ul>
      </div>
    </div>
  </div>

</main>

<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <!-- <a href="#">Back to top</a> -->
      <a href="#">トップに戻る</a>
    </p>
  </div>
</footer>
<script src="../../assets/js/vendor/holder.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>
  window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery-slim.min.js"><\/script>')
</script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script><script src="/docs/4.5/assets/js/vendor/anchor.min.js"></script>
<script src="/docs/4.5/assets/js/vendor/clipboard.min.js"></script>
<script src="/docs/4.5/assets/js/vendor/bs-custom-file-input.min.js"></script>
<script src="/docs/4.5/assets/js/src/application.js"></script>
<script src="/docs/4.5/assets/js/src/search.js"></script>
<script src="/docs/4.5/assets/js/src/ie-emulation-modes-warning.js"></script>
  </body>
</html>