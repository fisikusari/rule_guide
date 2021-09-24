<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
  private $client;

  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
  }



  public function rule_engine($token, $file)
  {

    $response = $this->client->request(
      'POST',
      'https://reqres.in/api/users',
      [
        'headers' => [
          'Accept' => 'application/json',
          'auth_bearer' => $token
        ],
        'body' => ['name' => $name, 'job' => 'Web Developer']
      ]
    );
    return $response->toArray();
  }
}
