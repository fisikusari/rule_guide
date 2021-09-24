<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
  /**
   * @Route("/lucky/number")
   */


  public function number(CallApiService $callApiService): Response
  {
    dd($callApiService)
    $response = $callApiService->getData();
    // $client = HttpClientInterface::create();
    // $response = $this->client->request(
    //   'GET',
    //   'ttps://reqres.in/api/users'
    // );
    // $number = random_int(0, 100);

    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, 'https://reqres.in/api/users?');
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $response = curl_exec($ch);

    // If using JSON...
    $data = json_decode($response);

    return $this->render('lucky/number.html.twig', [
      'data' => $data,
    ]);
  }

  public function store(): Requests
  {
  }
}
