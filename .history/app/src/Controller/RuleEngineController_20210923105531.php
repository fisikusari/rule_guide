<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\CallApiService;
use App\Service\FileUploader;
use App\Service\ValidateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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

  public function test(AuthService $authService, CallApiService $callApiService, FileUploader $uploader, Request $request): Response
  {
    // $email = $request->get('email');
    // $password = $request->get('password');
    $file = $request->files->get('file');
    $uploader->upload($uploadDir, $file, $filename);
    // $repositoryName = $request->get('repositoryName');
    // $commitName = $request->get('commitName');

    // $auth = $authService->login($email, $password);
    // $token = $auth['token'];
    // $upload_file_response = $callApiService->upload_file($token, $file, $repositoryName, $commitName);
    // $message = (new \Swift_Message('Hello Email'))
    //   ->setFrom('fisi.kusari@gmail.com')
    //   ->setTo('fisi.kusari@gmail.com')
    //   ->setBody('You should see me from the profiler!');
    // $mailer->send($message);
    return new Response($file->getClientOriginalName());


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
