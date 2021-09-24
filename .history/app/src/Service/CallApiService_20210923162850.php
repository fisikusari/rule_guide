<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class CallApiService
{
  private $client;

  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
  }



  public function upload_file($token, $filePath, $repositoryName, $commitName)
  {
    try {
      $body = [
        'fileData' => DataPart::fromPath($filePath),
        'repositoryName' => $repositoryName,
        'commitName' => $commitName,
        'version' => '1.0'
      ];

      $formData = new FormDataPart($body);
      $this->client->request('POST', 'https://app.debricked.com/api/1.0/open/uploads/dependencies/files', [
        'headers' => $formData->getPreparedHeaders()->toArray(),
        'body' => $formData->bodyToIterable(),
      ]);

      $response = $this->client->request(
        'POST',
        'https://app.debricked.com/api/1.0/open/uploads/dependencies/files',
        [
          'headers' => [
            'Content-Type' => 'multipart/form-data',
            'Authorization' => 'Bearer ' . $token
          ],
          'body' => $body
        ]
      );
      $content = $response->toArray();
      return $content;
    } catch (TransportExceptionInterface $e) {
      $content = $e->toArray();
    }
  }
}
