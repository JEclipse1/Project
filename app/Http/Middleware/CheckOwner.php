<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Board;

class CheckOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // requset -> 요청정보 담김 , Closure next -> 다음에 적용될 미들웨어
    public function handle($request, Closure $next)
    {
        // 로그인 한 사용자와 요청 정보에 있는 id(게시글의 아이디)를 이용해 게시글을 DB에서 가져오고
        // 그 가져온 게시글에 user_id와 비교
        // 다르면 back();  ,
        // 같으면 밑으로

        \Log::debug('middelware(auth)',['step1'=>'here1']);
        $user = Auth::user(); // 로그인 한 사용자의 정보 얻기

        //url에 포함된 정보 빼는법 ? boards{board}
        \Log::debug('middelware(auth)',['step2'=>'here2']);
        $id = $request->route('board');

        // 비교하려면 Board에 있는 정보 가져와야지ㅡ use주소 해주는거 잊지말고
        \Log::debug('middelware(auth)',['step3'=>'here3']);
        $b = Board::find($id);

        // 만약 게시글이 없거나 or 로그인 한 유저와 게시글의 유저 id가 다르면...
        \Log::debug('middelware(auth)',['step4'=>'here4']);
        if(!$b || $user->id != $b->user_id){
          flash('권한이 없습니다.');
          return back();
        }
        return $next($request);
    }
}
