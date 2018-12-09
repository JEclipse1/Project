<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Comment;
class CommentController extends Controller
{
  // 댓글 작성을 위해 db에서 불러옴
  public function writeComment(Request $request){
    DB::table('comments')->insert(
      [
       'user_id'=>$request->user_id,
       'board_id'=>$request->board_id,
       'name'=>$request->name,
       'content'=>$request->content
     ]);

     return $request;
  }

  // 댓글 삭제 기능
  public function deleteComment(Request $request){

        $id = $request->id;

        Comment::where('id',$id)->delete();
        return redirect(route('boards.show',['board_id'=>$request->board_id]));
    }
}
