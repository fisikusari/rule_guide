<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LuckyController extends AbstractController
{

  private $clients

  public function __construct(HttpClientInterface $client){
    
  }
  /**
   * @Route("/lucky/number")
   */
  public function number(CallApiService $callApiService): Response
  {
    dd($callApiService->getData());
    return $this->render('lucky/lucky.html.twig', [
      'controller_name' => LuckyController
    ]);
  }
}
