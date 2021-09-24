<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

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
   * notifier
   *
   * @var mixed
   */
  private $notifier;
  /**
   * __construct
   *
   * @param  mixed $mailer
   * @param  mixed $senderEmail
   * @return void
   */


  public function __construct(MailerInterface $mailer, NotifierInterface $notifier, string $senderEmail)
  {
    $this->mailer = $mailer;
    $this->senderEmail = $senderEmail;
    $this->notifier = $notifier;
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
      ->to($email)
      ->subject('Rule Engine Status')
      ->html($body);

    $this->mailer->send($email);

    $notification = (new Notification('Rule Engine Status', ['chat/slack']))
      ->content($body);
  }
}
