<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RuleengineController extends AbstractController
{
  /**
   * @Route("/ruleenigne")
   */

  public function number(CallApiService $callApiService): Response
  {
    $data = 'Hello world';
    dd($data);
    // return $this->render('ruleengine.html.twig', [
    //   'data' => $data
    // ]);
  }
}
