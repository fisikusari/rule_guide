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
    $data = 'Hello world';
    return $this->render('ruleengine.html.twig', [
      'data' => $data
    ]);
  }
}
