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
   * @param  mixed $notifier
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
    $this->notifier->send($notification);
  }
  /**
   * get_status
   *
   * @Route("/get-status", name="rule_engine_status")
   *
   * @param  mixed $authService
   * @param  mixed $callApiService
   * @param  mixed $request
   * @return Response
   */
  public function get_status(AuthService $authService, CallApiService $callApiService, Request $request): Response
  {

    //Email and password to generate JWT token 
    $email = $request->get('email');
    $password = $request->get('password');
    // Try to login and generate JWT token
    try {
      $auth = $authService->login($email, $password);
      $token = $auth['token'];
    } catch (\Exception $e) {
      return new JsonResponse(["message" => "The credentials used for the login requests towards the external api are not okay!"], $e->getCode());
    }

    $ciUploadId = $request->get('ciUploadId');
    try {
      $status = $callApiService->get_status($token, $ciUploadId);
      if ($status['progress'] == 100) {
        // is completed
      } else {
        //On progress
      }
      return new JsonResponse(['status' => $status], 200);
    } catch (\Exception $e) {
      return new JsonResponse(["message" => 'Something went wrong!'], $e->getCode());
    }
  }
}
