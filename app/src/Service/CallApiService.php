<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

/**
 * CallApiService
 */
class CallApiService
{
  /**
   * client
   *
   * @var mixed
   */
  private $client;
  /**
   * url
   *
   * @var mixed
   */
  private $api_url;

  /**
   * __construct
   *
   * @param  mixed $client
   * @param  mixed $api_url
   * @return void
   */

  public function __construct(HttpClientInterface $client, string $api_url)
  {
    $this->client = $client;
    $this->api_url = $api_url;
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
    $formData = new FormDataPart([
      'fileData' => DataPart::fromPath($filePath),
      'repositoryName' => $repositoryName,
      'commitName' => $commitName
    ]);

    $response = $this->client->request(
      'POST',
      $this->api_url . 'uploads/dependencies/files',
      [
        'headers' => array_merge(
          ['Authorization' => 'Bearer ' . $token],
          $formData->getPreparedHeaders()->toArray()
        ),
        'body' => $formData->bodyToIterable(),
      ]
    );

    return $response->toArray();
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
    $response = $this->client->request(
      'POST',
      $this->api_url . 'finishes/dependencies/files/uploads',
      [
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => 'Bearer ' . $token
        ],
        'body' => [
          'ciUploadId' => $ciUploadId,
        ],
      ]
    );

    return $response->getStatusCode();
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
      $this->api_url . 'ci/upload/status?ciUploadId=' . $ciUploadId,
      [
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => 'Bearer ' . $token
        ],
      ]
    );
    return $response->toArray();
  }
}
