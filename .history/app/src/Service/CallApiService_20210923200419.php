<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class CallApiService
{
  private $client;

  /**
   * __construct
   *
   * @param  mixed $client
   * @return void
   */
  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
  }



  /**
   * upload_file
   *
   * @param  mixed $token
   * @param  mixed $filePath
   * @param  mixed $repositoryName
   * @param  mixed $commitName
   * @return void
   */
  public function upload_file($token, $filePath, $repositoryName, $commitName)
  {
    $body = [
      'fileData' => DataPart::fromPath($filePath),
      'repositoryName' => $repositoryName,
      'commitName' => $commitName
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

  /**
   * conclude_file
   *
   * @param  mixed $token
   * @param  mixed $ciUploadId
   * @return void
   */
  public function conclude_file($token, $ciUploadId)
  {
    $body = [
      'ciUploadId' => $ciUploadId,
    ];
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

  /**
   * get_status
   *
   * @param  mixed $token
   * @param  mixed $ciUploadId
   * @return void
   */
  public function get_status($token, $ciUploadId)
  {
    $response = $this->client->request(
      'GET',
      'https://app.debricked.com/api/1.0/open/ci/upload/status?ciUploadId=' . $ciUploadId,
      [
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => 'Bearer ' . $token
        ],
      ]
    );
    $content = $response->toArray();
    return $content;
  }
}
