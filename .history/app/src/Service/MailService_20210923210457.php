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
  public function __construct(LoggerInterface $mailer)
  {
    $this->mailer = $mailer;
  }
}
