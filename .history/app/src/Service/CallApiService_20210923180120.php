<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class CallApiService
{
  private $client;
  $main_url = 'https://app.debricked.com/api/1.0';
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
      $response = $this->client->request(
        'POST',
        'https://app.debricked.com/api/1.0/open/uploads/dependencies/files',
        [
          'headers' => array_merge(
            ['Authorization' => 'Bearer ' . $token],
            $formData->getPreparedHeaders()->toArray()
          ),
          'body' => $formData->bodyToIterable(),
        ]
      );
      $content = $response->toArray();
      return $content;
    } catch (TransportExceptionInterface $e) {
      $content = $e->toArray();
    }
  }

  public function conclude_file()
  {
    $body = [
      'fileData' => DataPart::fromPath($filePath),
      'repositoryName' => $repositoryName,
      'commitName' => $commitName,
      'version' => '1.0'
    ];
    $formData = new FormDataPart($body);
    $response = $this->client->request(
      'POST',
      'https://app.debricked.com/api/1.0/open/finishes/dependencies/files/uploads',
      [
        'headers' => array_merge(
          ['Authorization' => 'Bearer ' . $token],
          $formData->getPreparedHeaders()->toArray()
        ),
        'body' => $formData->bodyToIterable(),
      ]
    );
  }
  public function get_status()
  {
    $method = 'GET';
    $body =
      $url = $main_uri + ' /hashashsdas';
  }
  public function api_call()
  {
  }
}