<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>advance</title>
    <link href="{{ asset('css/album.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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

<main role="main" class="container mt-5 pt-5">
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
</body>
</html>