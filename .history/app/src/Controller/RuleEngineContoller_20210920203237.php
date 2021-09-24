<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RuleengineController extends AbstractController
{
  /**
   * @Route("/ruleenigne")
   */
  public function index(): Response
  {
    $data = 'Hello world';
    // return $this->render('ruleengine.html.twig', [
    //   'data' => $data
    // ]);
  }
}
