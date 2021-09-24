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

  public function getData(): array
  {
    $response = $this->client->request(
      'GET',
      'https://reqres.in/api/users'
    );
    return $response->toArray();
  }

  public function test($name)
  {


    return $response->toArray();
  }
}
