<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Board;
use Illuminate\Support\Facades\DB;
use App\Comment;

class BoardsController extends Controller
{
    // 로그인 된 사람만 작성하게 하고 싶음
    // 미들웨어 -> auth 이용
    public function __construct(){
      $this->middleware('auth');
      $this->middleware('own')->only(['update','destroy']);  //12.4 추가 미들웨어 CheckOwner
    }   // 위의 컨트롤러에 포함된 함수들을 사용하려면 middleware -> 'auth' 에 걸림
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // index - 게시글 메인
    public function index(Request $request)
    {

        $page = $request->page;
        $searchbox = $request->search;
        $msgs = Board::orderBy('created_at', 'desc')->paginate(10); // 페이지네이션 , 정렬
        if($searchbox){
          $msgs = Board::where('title','like',"%$searchbox%")->orWhere('content','like',"%$searchbox%")->orderBy('created_at', 'desc')->paginate(3);
        }

        // $msgs = Board::all();  // Board에 있는 것 다 가지고 와

        $getDB = DB::table('boards')->select('content','title')->get(); // 12.7 추가. 테이블에 있는 정보 얻기

        return view('bbs.index')->with('msgs', $msgs)->with('page',$page)->with('getDB',$getDB)->with('searchbox',$searchbox);  // 12.7 DB 정보 with('getDB',$getDB); 추가

        // 본인 호출이던가..?
        // return __METHOD__;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     // create - 작성 폼
    public function create()
    {
        //
        return view('bbs.write_form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // store - 작성 코드
    public function store(Request $request)
    {
        // 1. 사용자 입력한 게시글 정보를 boards 테이블에 insert (title, content, 사용자 id )
        // DB::insert('insert into boards(title, content, user_id) values(?,?,?', [$resut->title, $request->content, $user_id]));

        $page = $request->page;

        $user = Auth::user();

        Board::create(['title'=>$request->title, 'content'=>$request->content, 'user_id'=>$user->id]);

        return redirect(route('boards.index' , ['page'=>1]));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // show - 이게 자세히 보기
    public function show(Request $request , $id)
    {
        //
        $board_id = $id;
        $page = $request->page;
        $board = Board::find($id);  // 모델에 있는 Board에서 user가 있어서 ..  $board->user->name .. 보드 테이블과 유저 테이블 belongsTo... 같은거 찾음
        $searchbox = $request->search;
        $board->hits++;
        $board->save();

        $comment = Comment::where('board_id',$id)->get();

        return view('bbs.show')->with('board' , $board)->with('page' , $page)->with('searchbox',$searchbox)->with('comments',$comment)->with('board_id',$board_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        $page = $request->page;
        $b = Board::find($id);
        $searchbox = $request->search;
        return view('bbs.edit')->with('board',$b)->with('page',$page)->with('searchbox',$searchbox);
        // return __METHOD__;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // update - 수정
    public function update(Request $request, $id)
    {
        // validate : 규칙에 준수했는지 확인 , 안되있으면 back
        $this->validate($request, [
          'title'=>'required',
          'content'=>'required'
        ]);
        // 수정하고자 하는 글이 로그인한 사용자의 글인지 체크
        // 그렇지 않으면 back,
        // 그렇다면 아래로

        $b = Board::find($id);
        $b->title=$request->title;
        $b->content = $request->content;
        $b->save();

        return redirect(route('boards.index' , ['page'=>$request->page]));  // 리다이렉트 하는 이유 : ?
        // return __METHOD__;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // destroy - 삭제
    public function destroy(Request $request,$id)
    {
      // 삭제하고자 하는 글이 로그인한 사용자의 글인지 체크
      // 그렇지 않으면 back,
      // 그렇다면 아래로

      // DB에서 id에 해당하는 게시글을 읽어와야 한다.
      // 다음 읽어온 그 글에 대해 삭제 요청한다.
      $b = Board::find($id);
      $b->delete();

      return redirect(route('boards.index' , ['page'=>$request->page]));
    }

    // 내 글만 보게 하는거
    public function myArticles(Request $request){
      // $msgs = Auth::user()->boards;
      $msgs = Board::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
      // 보드에 있는 유저 아이디 값, 그건 Auth에서 구할 수 있음, 여기에 체이닝,

      // 모델 user에 boards 정의한거
      return view('bbs.index')->with('msgs', $msgs)->with('page', $request->page);
    }

}
