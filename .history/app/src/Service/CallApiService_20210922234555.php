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



  public function test($name)
  {

    $response = $this->client->request(
      'POST',
      'https://reqres.in/api/users',
      [
        'headers' => [
          'Accept' => 'application/json',
        ],
        'body' => ['name' => $name, 'job' => 'Web Developer']
      ]
    );
    return $response->toArray();
  }
}
