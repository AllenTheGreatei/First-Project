<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Email extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;

  public $subject;
  public $content;
  public $gmail;

  public function __construct($subject, $content, $gmail)
  {
    $this->subject = $subject;
    $this->content = $content;
    $this->gmail = $gmail;
  }

  public function build()
  {
    return $this->view('email.otpsample'); // Specify the view name here
  }
}
