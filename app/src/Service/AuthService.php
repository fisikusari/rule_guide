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
   * auth_url
   *
   * @var mixed
   */
  private $auth_url;

  /**
   * __construct
   *
   * @param  mixed $client
   * @param  mixed $auth_url
   * @return void
   */
  public function __construct(HttpClientInterface $client, string $auth_url)
  {
    $this->client = $client;
    $this->auth_url = $auth_url;
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
      $this->auth_url,
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
