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



  public function upload_file($token, $uploadDir, $file, $repositoryName, $commitName)
  {
    try {
      $dataField = [
        'repositoryName' => $repositoryName,
        'commitName' => $commitName,
        'version' => '1.0'
      ];
      $formData = new FormDataPart($dataField);
      // $response = $this->client->request(
      //   'POST',
      //   'https://app.debricked.com/api/1.0/open/uploads/dependencies/files',
      //   [
      //     'headers' => [
      //       'Content-Type' => 'multipart/form-data',
      //       'Authorization' => 'Bearer ' . $token
      //     ],
      //     'body' => $formData->bodyToIterable()
      //   ]
      // );
      // $statusCode = $response->getStatusCode();
      // $contentType = $response->getHeaders()['content-type'][0];
      // $content = $response->getContent();
      $content = $formData->bodyToIterable();
      return $content;
    } catch (TransportExceptionInterface $e) {
      $content = $e->toArray();
    }
  }
}
