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
      'https://app.debricked.com/api/1.0/open/uploads/dependencies/files',
      [
        'headers' => [
          'Content-Type' => 'multipart/form-data',
          'Authorization' => 'Bearer ' . $token
        ],
        'body' => ['fileData' => $file]
      ]
    );
    return $response->toArray();
  }
}
