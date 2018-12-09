<?php

namespace App\Listeners;

use Mail;
use App\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendMail  $event
     * @return void
     */
    // php켜서 생성 Listener.. 가입자에게 메일을 보내는 곳
    public function handle(SendMail $event)
    {
      $uemail = $event->email;  // uemail에 event에 있는 email넣기
      $uname = $event->name;
      Mail::send(['html'=>'layouts.test'],['name','Sathak'],function($message) use ($uemail,$uname){ // use꼭 사용
          $message->to($uemail,$uname.'님')->subject('안녕하세요! 창목사이트입니다!.'); //to : 받는사람정보 , subject : 머릿말 정도?
          $message->from('kamizo222@gmail.com','창목'); // from : 보내는 사람
      });
    }
}
