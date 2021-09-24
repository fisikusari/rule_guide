<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class AuthService
{
  private $client;

  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
  }

  public function login($username): array
  {
    $response = $this->client->request(
      'POST',
      'https://app.debricked.com/api/login_check',
      'body' => ['username' => $username, 'password' => 'Web Developer']
    );
    return $response->toArray();
  }
}
