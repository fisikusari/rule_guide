<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyController extends AbstractController
{
  /**
   * @Route("/lucky/number")
   */
  public function number(): Response
  {
    $number = random_int(0, 100);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'www.someapi.com?param1=A&param2=B');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    // If using JSON...
    $data = json_decode($response);

    return $this->render('lucky/number.html.twig', [
      'number' => $data,
    ]);
  }
}
