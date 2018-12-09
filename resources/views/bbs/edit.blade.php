@extends('layouts.app')

@section('title')
글 수정폼
@endsection

@section('cssNscript')
<link href="/dist/dropzone.css" rel="stylesheet">
<script src="/dist/dropzone.js"></script>
<script type="text/javascript" src="{{asset('ckeditor/ckeditor.js')}}"></script>  <!-- asset이 public 먼저 잡아줌-->
@endsection


@section('content')
<div class="container">
  <form action="{{route('boards.update', ['board'=>$board->id, 'page'=>$page])}}" method="post">
    @csrf
    @Method('PATCH')
    <div class="form-group">
      <label for="title">제목</label>
      <input type="text" class="form-control" id="title" name="title" value="{{$board->title}}">
        <span>
          @if($errors->has('title')){{$errors->first('title')}}
          @endif
        </span>

    </div>

    <div class="form-group">
      <label for="content">
        내용 :<textarea class="form-control" rows="5" id="content" name="content" required>{{$board->content}}</textarea>
      </label>
      <script>
        CKEDITOR.replace('content',{
          filebrowserUploadUrl:'upload.php?type=image',
          //extraPlugins:'uploadimage'
        });
      </script>
    </div>

    <button class="btn btn-primary">수정하기</button>
    <button class="btn btn-primary" onclick="{{route('boards.index',['page'=>1])}}">목록</button>


</form>
</div>
@endsection
