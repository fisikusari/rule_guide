<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * NotifyService
 */
class NotifyService
{
  /**
   * mailer
   *
   * @var mixed
   */
  private $mailer;

  /**
   * senderEmail
   *
   * @var mixed
   */
  private $senderEmail;
  /**
   * __construct
   *
   * @param  mixed $mailer
   * @param  mixed $senderEmail
   * @return void
   */
  public function __construct(\Swift_Mailer $mailer, string $senderEmail)
  {
    $this->mailer = $mailer;
    $this->senderEmail = $senderEmail;
  }

  /**
   * sendMail
   *
   * @param  mixed $email
   * @param  mixed $body
   * @return void
   */
  public function sendNotification($email, $body)
  {
    $email = (new Email())
      ->from($this->senderEmail)
      ->to('fisi.kusari@gmail.com')
      ->subject('Rule Engine Status')
      ->html($body);

    $this->mailer->send($email);
    // $message = (new \Swift_Message('Rule Engine'))
    //   ->setFrom($this->senderEmail)
    //   ->setTo($email)
    //   ->setBody($body);
    // $this->mailer->send($message);
  }
}
