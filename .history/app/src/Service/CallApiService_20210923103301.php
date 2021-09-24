<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CallApiService
{
  private $client;

  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
  }



  public function upload_file($token, $file, $repositoryName, $commitName)
  {
    $response = $this->client->request(
      'POST',
      'https://app.debricked.com/api/1.0/open/uploads/dependencies/files',
      [
        'headers' => [
          'Content-Type' => 'multipart/form-data',
          'Authorization' => 'Bearer ' . $token
        ],
        'body' => [
          'fileData' => $file,
          'repositoryName' => $repositoryName,
          'commitName' => $commitName
        ]
      ]
    );
    $statusCode = $response->getStatusCode();
    // $statusCode = 200
    $contentType = $response->getHeaders()['content-type'][0];
    // $contentType = 'application/json'
    $content = $response->getContent();
    // $content = '{"id":521583, "name":"symfony-docs", ...}'
    $content = $response->toArray();
    // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

    return $content;
  }
}
