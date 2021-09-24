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
  public function sendMail()
  {
    $email = $this->getParameter('app.upload_in_progress');
    $message = (new \Swift_Message('Rule Engine'))
      ->setFrom('te877868@gmail.com')
      ->setTo($email)
      ->setBody('You should see me from the profiler!');
    $this->mailer->send($message);
  }
}
