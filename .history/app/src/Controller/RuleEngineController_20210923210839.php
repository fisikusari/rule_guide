<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\CallApiService;
use App\Service\FileUploader;
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
   * test
   *
   * @Route("/rule-engine", name="rule_engine")
   *
   * @param  mixed $authService
   * @param  mixed $callApiService
   * @param  mixed $uploadDir
   * @param  mixed $uploader
   * @param  mixed $request
   * @return Response
   */
  public function test(AuthService $authService, CallApiService $callApiService, string $uploadDir, FileUploader $uploader, Request $request): Response
  {
    // $email = $request->get('email');
    // $password = $request->get('password');


    // $file = $request->files->get('file');
    // $filename = $file->getClientOriginalName();
    // $uploader->upload($uploadDir, $file, $filename);
    // $file_name = $uploadDir . '/' . $filename;
    // $repositoryName = $request->get('repositoryName');
    // $commitName = $request->get('commitName');

    // $auth = $authService->login($email, $password);
    // $token = $auth['token'];

    // $upload_file_response = $callApiService->upload_file($token, $file_name, $repositoryName, $commitName);
    // $ciUploadId = (string)$upload_file_response['ciUploadId'];

    // $conclude_file = $callApiService->conclude_file($token, $ciUploadId);
    // if ($conclude_file == 204) {
    //   // get request
    //   $status = $callApiService->get_status($token, $ciUploadId);
    //   return new Response(json_encode($status));
    // } else {
    //   // Failed to upload
    // }

    $this->mailService();
    return new Response(json_encode('test'));

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
