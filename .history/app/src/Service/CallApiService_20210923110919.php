<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Part\DataPart;

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
      $file =
        $response = $this->client->request(
          'POST',
          'https://app.debricked.com/api/1.0/open/uploads/dependencies/files',
          [
            'headers' => [
              'Content-Type' => 'multipart/form-data',
              'Authorization' => 'Bearer ' . $token
            ],
            'body' => [
              'fileData' => DataPart::fromPath($file),
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
      $content = $e->toArray();
    }
  }
}
