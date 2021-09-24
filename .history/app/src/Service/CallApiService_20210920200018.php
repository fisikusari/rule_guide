<?php

namespace App\Service;

class CallApiService
{
  private $client;

  public function __construct()
  {
  }

  public function getData(): array
  {
    return ['test1', 'test2'];
  }
}
