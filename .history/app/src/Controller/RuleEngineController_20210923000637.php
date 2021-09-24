<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\CallApiService;
use App\Service\ValidateService;
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

  public function test(AuthService $authService, CallApiService $callApiService, \Swift_Mailer $mailer, Request $request): Response
  {
    $email = $request->get('email');
    $password = $request->get('password');
    $file = $request->files->get('file');
    // $file = $request->get('file');

    // $auth = $authService->login($email, $password);
    // $token = $auth['token'];
    // $response = $callApiService->rule_engine($token, $file);
    // $message = (new \Swift_Message('Hello Email'))
    //   ->setFrom('fisi.kusari@gmail.com')
    //   ->setTo('fisi.kusari@gmail.com')
    //   ->setBody('You should see me from the profiler!');
    // $mailer->send($message);
    return new Response(json_encode($file));

    //  
    // $password = $request->get('password');
    // $validateService->validateRequest($email, $password);

    // $response_1 = $this->getParameter('app.app_alow_send_email');
    // $response_2 = $this->getParameter('app.app_show_upload_progress');

    // $response = [
    //   'response1' => $response_1,
    //   'response2' => $response_2,
    //   'email' => $email,
    //   'password' => $password
    // ];

    // $name = $request->get('name');

  }
}
