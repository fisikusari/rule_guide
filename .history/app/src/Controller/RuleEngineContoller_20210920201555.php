<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RuleEngineController extends AbstractController
{
  /**
   * @Route("/ruleenigne" name="rule_engine")
   */
  public function index(): Response
  {
    return $this->render('lucky/number.html.twig', [
      'data' => $data
    ]);
  }
}
