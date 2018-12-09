<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Attachment;
use App\Board;

class AttachmentsController extends Controller
{
    public function __construct(){
      $this->middleware('auth');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
          1. 전송받은 파일을 지정된 폴더에 저장한다.
            1.1 어디 폴더에 저장하나?
              public/files/사용자_아이디/ 에 저장
          2. 파일정보를 attachments 테이블에 저장한다.
          3. 저장 성공 결과를 클라이언트에 송신한다.
        */

        // 1번 구현
        if($request->hasFile('file')) {
          $file = $request->file('file');

          $filename = /*str_random().*/filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL); // 새니타이즈 : 소독 , 잘못된 문자의 url을 삭제??해줌
          $bytes = $file->getSize();
          $user = \Auth::user();  // 로그인한 사용자 정보
          $path = public_path('files') . DIRECTORY_SEPARATOR .  $user->id;

          if (!File::isDirectory($path)) {
              File::makeDirectory($path, 0777, true, true); //0777 : rwx권한 다주겠다.(누구나 읽고 쓸수있도록)
          }

          $file->move($path, $filename);
          //////////////////////////////////////////////////////////////////////////////////////////////////


          //// 2번 구현 ////
          $payload = [
      				'filename'=>$filename,
      				'bytes'=> $bytes,
      				'mime'=>$file->getClientMimeType()
      			];

         $attachment =  Attachment::create($payload);
          ///////////////////////////////////////////////
        }

        return response()->json($attachment, 200);  // 서버에서 정상전송이면 200, 오류면 다른 번호
        // {'filename':'a.jpg' , 'bytes':4567, 'mime':'jpg', 'id':1}   //json 형식 , 이런 형태로 가벌임

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filename =  $request->filename;
        $attachment = Attachment::find($id);
        $attachment->deleteAttachedFile($filename);
        $attachment->delete();
        $user = \Auth::user();
        /*
        $path = public_path('files') . DIRECTORY_SEPARATOR .  $user->id . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($path)) {
          unlink($path);
        }
        */
        return $filename;
    }
}
