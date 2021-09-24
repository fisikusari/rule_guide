<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * AuthService
 */
class AuthService
{
  /**
   * client
   *
   * @var mixed
   */
  private $client;

  /**
   * __construct
   *
   * @param  mixed $client
   * @return void
   */
  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
  }

  /**
   * login
   *
   * @param  mixed $email
   * @param  mixed $password
   * @return array
   */
  public function login($email, $password): array
  {
    $response = $this->client->request(
      'POST',
      'https://app.debricked.com/api/login_check',
      [
        'headers' => [
          'Accept' => 'application/json',
        ],
        'body' => ['_username' => $email, '_password' => $password]
      ]
    );
    return $response->toArray();
  }
}
