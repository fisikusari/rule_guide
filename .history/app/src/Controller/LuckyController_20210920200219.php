<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LuckyController extends AbstractController
{

  private $client;

  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
  }

  /**
   * @Route("/lucky/number")
   */

  public function number(CallApiService $callApiService): Response
  {
    dd($callApiService->getData());
    $response = $this->client->request(
      'GET',
      'https://reqres.in/api/users'
    );
    return $this->render('lucky/lucky.html.twig', [
      'controller_name' => LuckyController
    ]);
  }
}
