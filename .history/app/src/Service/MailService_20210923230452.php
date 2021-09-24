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
   * @param  mixed $body
   * @return void
   */
  public function sendMail($email, $body)
  {
    $admin_email = $this->getParameter('app.upload_in_progress');
    $message = (new \Swift_Message('Rule Engine'))
      ->setFrom($admin_email)
      ->setTo($email)
      ->setBody($body);
    $this->mailer->send($message);
  }
}
