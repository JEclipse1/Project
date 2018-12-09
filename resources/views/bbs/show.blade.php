@extends('layouts.app')

@section('content')

  <div class="container">
    <table class="table table-hover">
      <div class="jumbotron">
        <h2> 게시글 상세 내용 </h2>
      </div>
      <tr>
        <td>제목</td>
        <td>{{$board->title}}</td>
      </tr>

      <tr>
        <td>작성자</td>
        <td>{{$board->user->name}}</td>
      </tr>

      <!-- {{$board}} -->
      <tr>
        <td>내용</td>
        <td>{!!$board->content!!}</td>
      </tr>

      <tr>
        <td>조회수</td>
        <td>{{$board->hits}}</td>
      </tr>

      <tr>
        <td>생성일</td>
        <td>{{$board->created_at}}</td>
      </tr>
    </table>
  </div>

  <hr>
  <!-- 댓글 리스트도 보여주자-->
  <!-- <h3>댓글리스트<h3>
    <table class="table">
      <tr>
        <td>작성자</td>
        <td>내용</td>
      </tr>
      @foreach($board->comments as $c)
        <tr>
          <td>{{$c->user->name}}</td>
          <td>{{$c->content}}</td>
        </tr>
      @endforeach
    </table>

    <div class="row">
      <div class="col-md-6">
        <input type="text" id="" class="form-control">
      </div>
      @if(Auth::user()->id == $board->user_id)
        <input type="button" id="push_comment" class="btn btn-primary float-right" name="" value="댓글작성">
      @endif
    </div>
    <br> -->

    <div class="container">
    	<form class="form" id="comment_form" action="/comment" method="post">
    		@csrf
    		<table class="table">
    			   <input type="hidden" name="board_id" value="{{$board->id}}" readonly>
             <input type="hidden" class="form-control" name="user_id" value="{{auth()->user()->id}}" readonly>
             <!-- <tr>
             <td>게시글 번호 : </td>
             <td>{{$board->id}}</td>
           </tr> -->
    			<tr>
    				<td>작성자</td>
    				<td><input type="text" class="form-control" name="name" value="{{auth()->user()->name}}" readonly></td>
    			</tr>
    			<tr>
    				<td>댓글 내용</td>
    				<td><textarea class="form-control" name="content" rows="8" cols="80"></textarea></td>
    			</tr>
    			<tr>
    				<td><input type="button" class="btn btn-primary" id="push_comment" name="" value="댓글등록"></td>
    			</tr>
    		</table>
    		<table class="table" id="comments_table" cellpadding="5" cellspacing="2" style="word-break:break-all;">

          @foreach($comments as $comment)
          <tr>
            <td style="width:150px;"> {{ $comment->name}}</td>
            <td>{{$comment->content}}&nbsp;&nbsp;<button type="button" name="button"  class="btn btn-danger" onclick="location.href='{{route('deleteComment',['id'=>$comment->id,'board_id'=>$board_id])}}'">삭제</button></td>

          </tr>
          @endforeach
    		</table>
    	</form>
    </div>


<script>
$(function(){
    $('#push_comment').click(function() {
        var params = $("#comment_form").serialize();
        $.ajax({
            type:"POST",
            url:"{{ url('/comment') }}",
            data:params,
            dataType:"html",
            success:function (data) {
                var parserData = JSON.parse(data);
                var writer = parserData['name'];
                var contents = parserData['content'];
                // var created_at = parserData['created_at'];

                var innerComment = '<tr><td style="width:150px;">' + writer + '</td><td>'+ contents + '</td></tr>';
                // var innerComment = '<tr><td style="width:150px;">' + writer + '</td><td>'+ contents + '</td><td>' + created_at + '</td></tr>';
                $('#comments_table').append(innerComment);
            }
        })
    })
})
</script>

    <div class="row">
      <button class="btn btn-primary" onclick='location.href="{{route('boards.index' , ['search'=>$searchbox,'page'=>$page])}}"'>목록</button>
      <!-- <button class="btn btn-primary" onclick='location.href="/boards?page={{$page}}"'>목록</button> -->
      <!-- 만약 로그인한 사용자의 id가 board객체의 user_id와 같으면 밑의 버튼을 나오게 하라-->
      @if(Auth::user()->id == $board->user_id)
      <button class="btn btn-warning" onclick="location.href='{{route('boards.edit', ['board'=>$board->id, 'page'=>$page])}}'">수정</button>
      <form action="{{route('boards.destroy' , ['board'=>$board->id])}}" method="post">
        <button type="submit" class="btn btn-danger">삭제</button>
        @csrf
        @method('delete')
      </form>
      @endif
      <!-- @if(Auth::user()->id == $board->user_id) -->
      <!-- @endif -->
    </div>
@endsection
