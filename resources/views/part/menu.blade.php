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
          <a class="nav-link" href="localhost/boards">게시글 리스트</a>
          <!-- ./ 은 이 방법은 상대패스 현재폴더. 즉 현재폴더/게시판/board.php-->
          <!-- /현재폴더/게시판/board.php 은 절대패스 -->
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/create">글쓰기</a>

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
          <a class="nav-link" href="#">장바구니</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
