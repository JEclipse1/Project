<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>  <!-- defer 는 지연?? 해서 이거 뺴줘야 자동검색기능 js랑 충돌 안됨-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="{{asset('/icon/css/font-awesome.min.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('cssNscript')  <!--12.7 드랍존 추가-->

    <!-- Bootstrap core CSS -->
</head>
<body>
    <!-- Navigation -->
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/">Start EnjoyLife</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/boards">게시글 리스트</a>
              <!-- ./ 은 이 방법은 상대패스 현재폴더. 즉 현재폴더/게시판/board.php-->
              <!-- /현재폴더/게시판/board.php 은 절대패스 -->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="boards/create">글쓰기</a>

              @guest
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/login">로그인</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/register">회원가입</a>
            </li>

            @else
            <li class="nav-item">
              <a class="nav-link" href="/logout">로그아웃</a>
            </li>
            @endguest

            <li class="nav-item">
              <a class="nav-link" href="/cart">장바구니</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Header -->
    <div class="jumbotron text-center" style="background-image:url(http://image.babosarang.co.kr/product/detail/GRK/1201161306517811/_400.jpg); height: 150px; width: 100%;">
      <h1 style="color: white;">This is ToyStore</h1>
    </div>
    <div class="container">
      <main class="py-4">
          @include('flash::message')
          @yield('content')
          @yield("container")
      </main>
    </div>
    @yield('footer')


</body>
</html>
