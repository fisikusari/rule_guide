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
    $admin_email = $this->getParameter('app.upload_in_progress');
    $message = (new \Swift_Message('Rule Engine'))
      ->setFrom($admin_email)
      ->setTo($email)
      ->setBody('You should see me from the profiler!');
    $this->mailer->send($message);
  }
}
