<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\CallApiService;
use App\Service\FileUploader;
use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    try {
      $auth = $authService->login($email, $password);
    } catch (\Exception $e) {
      return new JsonResponse(["message" => "The credentials used for the login requests towards the external api are not okay!"], $e->getCode());
    }
    $token = $auth['token'];

    try {
      $upload_file_response = $callApiService->upload_file($token, $file_name, $repositoryName, $commitName);
      $upload_in_progress = $this->getParameter('app.upload_in_progress');
      if ($upload_in_progress) {
        $message = "The uploading has started";
        $mailService->sendMail($email, $message);
      }
    } catch (\Exception $e) {
      $message = "The upload is not completed";
      $mailService->sendMail($email, $message);
      return new JsonResponse(["message" => $message], $e->getCode());
    }

    $ciUploadId = (string)$upload_file_response['ciUploadId'];

    try {
      $conclude_file = $callApiService->conclude_file($token, $ciUploadId);
    } catch (\Exception $th) {
      return new JsonResponse(["message" => 'Something went wrong!'], $e->getCode());
    }

    if ($conclude_file == 204) {
      // get request
      $status = $callApiService->get_status($token, $ciUploadId);
      return new JsonResponse($status);
    } else {
      $message = 'The upload failed';

      if ($message) {
        $mailService->sendMail($email, $message);
      }
      return new JsonResponse(["message" => $message]);
    }
  }
}
