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
    try {
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
      $contentType = $response->getHeaders()['content-type'][0];
      $content = $response->getContent();
      $content = $response->toArray();

      return $content;
    } catch (TransportExceptionInterface $e) {
      //throw $th;
    }
  }
}
