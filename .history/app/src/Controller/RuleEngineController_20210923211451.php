<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\CallApiService;
use App\Service\FileUploader;
use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
  public function test(AuthService $authService, CallApiService $callApiService, string $uploadDir, FileUploader $uploader, MailService $mailService, Request $request): Response
  {
    $email = $request->get('email');
    $password = $request->get('password');


    $file = $request->files->get('file');
    $filename = $file->getClientOriginalName();
    $uploader->upload($uploadDir, $file, $filename);
    $file_name = $uploadDir . '/' . $filename;
    $repositoryName = $request->get('repositoryName');
    $commitName = $request->get('commitName');

    $auth = $authService->login($email, $password);
    $token = $auth['token'];

    $upload_file_response = $callApiService->upload_file($token, $file_name, $repositoryName, $commitName);
    $ciUploadId = (string)$upload_file_response['ciUploadId'];

    $conclude_file = $callApiService->conclude_file($token, $ciUploadId);
    if ($conclude_file == 204) {
      // get request
      $status = $callApiService->get_status($token, $ciUploadId);
      return new Response(json_encode($status));
    } else {
      $message = 'The upload failed';

      if ($message) {
        $mailService->sendMail($email, $message);
      }
      return new Response($message);
    }
  }
}
