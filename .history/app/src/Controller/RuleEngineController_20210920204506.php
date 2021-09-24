<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RuleEngineController extends AbstractController
{

  /**
   * @Route("/rule-engine")
   */

  public function index(CallApiService $callApiService): Response
  {
    return $this->render('rule_engine/index.html.twig');
  }
}
