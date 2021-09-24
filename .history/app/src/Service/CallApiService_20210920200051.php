<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
  private $client;

  public function __construct()
  {
    $this->client = $client;
  }

  public function getData(): array
  {
    return ['test1', 'test2'];
  }
}
