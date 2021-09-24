<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class RuleEngineController extends AbstractController
{

  /**
   * @Route("/rule-engine", name="rule_engine")
   */

  public function index(): Response
  {
    return $this->render('rule_engine/index.html.twig');
  }

  /**
   * @Route("/rule-engine", name="rule_engine_test")
   */

  public function test(CallApiService $callApiService, MailerInterface $mailer, Request $request): Response
  {
    $name = $request->get('name');
    $data = $callApiService->test($name);
    $email = (new Email())
      ->from('fisnik@kutia.net')
      ->to('test@example.com')
      ->subject('The rule engine is working')
      ->body('this is test message');
    return $this->render('rule_engine/index.html.twig', [
      'data' => $data
    ]);
    // return $this->redirectToRoute('rule_engine', [
    //   'data' => $data
    // ], 307);
    // dd($data);
  }
}
