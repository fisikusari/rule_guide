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
      'https://app.debricked.com/api/{version}/open/uploads/dependencies/files',
      [
        'headers' => [
          'Content-Type' => 'multipart/form-data',
          'auth_bearer' => $token
        ],
        'body' => ['name' => $name]
      ]
    );
    return $response->toArray();
  }
}
