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

    $response_1 = $this->getParameter('app.app_alow_send_email');
    $response_2 = $this->getParameter('app.app_show_upload_progress');
    $response = [
      'response1' => $response_1,
      'response2' => $response_2,
      'email' => $request->get('email')
    ];
    // $email = (new Email())
    //   ->from('fisnik@kutia.net')
    //   ->to('fisnik@kutia.net')
    //   ->subject('The rule engine is working')
    //   ->html('this is test message from rule engine api');
    // $mailer->send($email);
    // $name = $request->get('name');
    return new Response($response);
  }
}
