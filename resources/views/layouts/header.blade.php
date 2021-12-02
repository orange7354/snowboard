<!doctype html>
<html lang="ja" >
  <head>
    <title>アルバムサンプル for Bootstrap · Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="{{ asset('css/album.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body >
    <a id="skippy" class="sr-only sr-only-focusable" href="#content">
  <div class="container">
    <span class="skiplink-text">Skip to main content</span>
  </div>
</a>

<header class="pb-5">
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <!-- <a class="navbar-brand" href="#">Fixed navbar</a> -->
    <a class="navbar-brand" href="#">固定ナビゲーションバー</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <!-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> -->
          <a class="nav-link" href="{{ route('question.index') }}">ホーム <span class="sr-only">（現在位置）</span></a>
        </li>
        <li class="nav-item"> 
          <!-- <a class="nav-link" href="#">Link</a> -->
          <a class="nav-link" href="{{ url('/myquestion') }}" action="GET">質問履歴</a>
        </li>
        <li class="nav-item">
          <!-- <a class="nav-link disabled" href="#">Disabled</a> -->
          <a class="nav-link disabled" href="#">無効</a>
        </li>
        @if(Route::has('login'))
            @auth
              <li class="nav-item">
                <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
              </li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
              <a href="{{ url('/home') }}" class="nav-link">Home</a>
            @else
              <a href="{{ route('login') }}" class="nav-link">ログイン</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="nav-link">登録する</a>
              @endif
            @endauth
        @endif
      </ul>
      <form class="form-inline mt-2 mt-md-0">
        <!-- <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search"> -->
        <input class="form-control mr-sm-2" type="text" placeholder="検索" aria-label="Search">
        <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> -->
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
      </form>
    </div>
  </nav>
</header>

<main role="main" class="container">
    @yield('content')
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