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
  }

  public function conclude_file($token, $ciUploadId)
  {
    $body = [
      'ciUploadId' => $ciUploadId,
      'version' => '1.0'
    ];
    // $formData = new FormDataPart($body);
    $response = $this->client->request(
      'POST',
      'https://app.debricked.com/api/1.0/open/finishes/dependencies/files/uploads',
      [
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => 'Bearer ' . $token
        ],
        'body' => $body,
      ]
    );
    $content = $response->getStatusCode();
    return $content;
  }

  public function get_status($token, $ciUploadId)
  {
    // $body = 
    $response = $this->client->request(
      'GET',
      'https://app.debricked.com/api/1.0/open/ci/upload/status',
      [
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => 'Bearer ' . $token
        ],
        'body' => $body,
      ]
    );
    $content = $response->toArray();
    return $content;
  }
}
