<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController
{
  /**
   * @Route("/lucky/number")
   */



  public function number(CallApiService $callApiService): Response
  {
    dd($callApiService);
  }

  public function store(): Requests
  {
  }
}
