<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LuckyController extends AbstractController
{

  /**
   * @Route("/lucky/number")
   */

  public function number(CallApiService $callApiService): Response
  {
    $data = $callApiService->getData();
    return $this->render('lucky/number.html.twig', [
      'data' => $data
    ]);
  }
}
