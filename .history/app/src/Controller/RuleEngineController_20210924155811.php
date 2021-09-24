<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\CallApiService;
use App\Service\FileUploader;
use App\Service\NotifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * RuleEngineController
 */
class RuleEngineController extends AbstractController
{

  /**
   * rule_engine
   *
   * @Route("/rule-engine", name="rule_engine")
   *
   * @param  mixed $authService
   * @param  mixed $callApiService
   * @param  mixed $uploadDir
   * @param  mixed $uploader
   * @param  mixed $notifyService
   * @param  mixed $request
   * @return Response
   */

  public function rule_engine(AuthService $authService, CallApiService $callApiService, string $uploadDir, FileUploader $uploader, NotifyService $notifyService, Request $request): Response
  {

    // Required field 

    $repositoryName = $request->get('repositoryName');
    $commitName = $request->get('commitName');

    // Try to login and generate JWT token

    $email = $request->get('email');
    $password = $request->get('password');

    try {
      $auth = $authService->login($email, $password);
      $token = $auth['token'];
    } catch (\Exception $e) {
      return new JsonResponse(["message" => "The credentials used for the login requests towards the external api are not okay!"], $e->getCode());
    }

    // Get files from request and upload on uploadDir folder.

    $files = $request->files->get('file');

    foreach ($files as $file) {
      $filename = $file->getClientOriginalName();
      $uploader->upload($uploadDir, $file, $filename);
      $file_name = $uploadDir . '/' . $filename;
      // Upload file for test
      try {
        $upload_file_response = $callApiService->upload_file($token, $file_name, $repositoryName, $commitName);
        $ciUploadId = (string)$upload_file_response['ciUploadId'];
      } catch (\Exception $e) {
        $message = "The upload is not completed";
        return new JsonResponse(["message" => $message], $e->getCode());
      }

      // Conclude Uploaded File

      try {
        $conclude_file = $callApiService->conclude_file($token, $ciUploadId);
        $message = 'Your Upload Id  for' . $file_name . 'is' . $ciUploadId;
        $notifyService->sendNotification($email, $message);
        // return new JsonResponse(['message' => $message], 200);
      } catch (\Exception $e) {
        return new JsonResponse(["message" => 'Something went wrong!'], $e->getCode());
      }
    }
  }


  /**
   * get_status
   *
   * @Route("/get-status", name="rule_engine_status")
   *
   * @param  mixed $authService
   * @param  mixed $callApiService
   * @param  mixed $request
   * @param  mixed $notifyService
   * @return Response
   */
  public function get_status(AuthService $authService, CallApiService $callApiService, NotifyService $notifyService, Request $request): Response
  {

    //Email and password to generate JWT token 

    $email = $request->get('email');
    $password = $request->get('password');
    $ciUploadId = $request->get('ciUploadId');

    //Env Variables

    $vulnerabilities_value = $this->getParameter('app.vulnerabilities_value');
    $upload_in_progress = $this->getParameter('app.upload_in_progress');
    $upload_failed = $this->getParameter('app.upload_failed');

    // Try to login and generate JWT token

    try {
      $auth = $authService->login($email, $password);
      $token = $auth['token'];
    } catch (\Exception $e) {
      return new JsonResponse(["message" => "The credentials used for the login requests towards the external api are not okay!"], $e->getCode());
    }

    try {
      $status = $callApiService->get_status($token, $ciUploadId);
      if ($status['progress'] == 100) {
        $message = 'Total number of the vulnerabilities found is ' . $status['vulnerabilitiesFound'];
        if ($vulnerabilities_value < $status['vulnerabilitiesFound']) {
          $notifyService->sendNotification($email, $message);
        }
        return new JsonResponse(['message' => $message], 200);
      } else {
        $message = 'The upload is in progress';
        if ($upload_in_progress) {
          $notifyService->sendNotification($email, $message);
        }
        return new JsonResponse(['message' => $message], 200);
      }
    } catch (\Exception $e) {
      $message = 'The upload has failed';
      if ($upload_failed) {
        if ($upload_in_progress) {
          $notifyService->sendNotification($email, $message);
        }
      }
      return new JsonResponse(["message" => $message], $e->getCode());
    }
  }
}
