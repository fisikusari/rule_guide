<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MailService
{
  /**
   * mailer
   *
   * @var mixed
   */
  private $mailer;
  public function __construct(\Swift_Mailer $mailer)
  {
    $this->mailer = $mailer;
  }

  /**
   * sendMail
   *
   * @param  mixed $email
   * @param  mixed $message
   * @return void
   */
  public function sendMail($email, $message)
  {
    $message = (new \Swift_Message('Hello Email'))
      ->setFrom('te877868@gmail.com')
      ->setTo('fisi.kusari@gmail.com')
      ->setBody('You should see me from the profiler!');
    $mailer->send($message);
  }
}
