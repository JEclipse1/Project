  @extends('layouts.app')


@section('content')
<script type="text/javascript" src="/jquery/lib/jquery.js"></script>
<script type='text/javascript' src='/jquery/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='/jquery/lib/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='/jquery/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="/jquery/jquery.autocomplete.css"/>

<div class="container">
  <table class="table table-hover">
      <tr>
          <td>제목</td>
          <td>작성자</td>
          <td>조회수</td>
      <tr>
    @foreach($msgs as $msg)
      <tr>
          <td>
            <a href="{{route('boards.show', ['board'=>$msg->id ,'search'=>$searchbox, 'page'=>$page])}}">  <!-- msg에 값이 담겨 있으니 msg에 id 받자-->
              {{$msg->title}}
            </a>
          </td>
          <td>{{$msg->user->name}}</td>
          <td>{{$msg->hits}}</td>
      <tr>
    @endforeach
  </table>
</div>

<input type="button" value="글쓰기" onclick="location.href='{{route('boards.create')}}'" class="btn btn-primary">

    <input type="text" id="inputText" class="searchbox" name="searchbox" value="">&nbsp;
    <button type="button" class="btn btn-dange" onclick="searchBtn(<?=$page?>)">검색</button>


<!-- 검색 자동완성 기능 , 스크립트는 상속받는 app에 있음  -->
<script>
function searchBtn(page) {
    // var searchValue = document.getElementById('inputState').value;
    var search = document.getElementById('inputText').value;
    page = 1;
    var url = 'boards?search=' + search + '&page=' + page;

    location.href = url;
}


    var availableTags = [];
    var getDB = {!! $getDB !!}

    for (var i in getDB) {
        for (var j in getDB[i]) {
                availableTags.push([getDB[i][j]]);
        }
    }
    $(document).ready(function() {
        $("#inputText").autocomplete(availableTags,{
            matchContains: true,
            selectFirst: false
        });
    });
</script>

  <!-- {{$msgs->links()}} -->
  {{$msgs->appends(['search'=>$searchbox])->links()}}
@endsection

@section('footer')
  @include('part.footer')
@endsection
