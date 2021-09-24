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

    // Get file from request and upload on uploadDir folder.

    $file = $request->files->get('file');
    $filename = $file->getClientOriginalName();
    $uploader->upload($uploadDir, $file, $filename);
    $file_name = $uploadDir . '/' . $filename;

    //Email and password to generate JWT token 
    $email = $request->get('email');
    $password = $request->get('password');

    // Required field 
    $repositoryName = $request->get('repositoryName');
    $commitName = $request->get('commitName');


    // Env Variables 
    // $vulnerabilities_value = $this->getParameter('app.vulnerabilities_value');

    // Try to login and generate JWT token
    try {
      $auth = $authService->login($email, $password);
      $token = $auth['token'];
    } catch (\Exception $e) {
      return new JsonResponse(["message" => "The credentials used for the login requests towards the external api are not okay!"], $e->getCode());
    }

    // Upload file for test
    try {
      $upload_file_response = $callApiService->upload_file($token, $file_name, $repositoryName, $commitName);
      $upload_in_progress = $this->getParameter('app.upload_in_progress');
      $ciUploadId = (string)$upload_file_response['ciUploadId'];
    } catch (\Exception $e) {
      $message = "The upload is not completed";
      return new JsonResponse(["message" => $message], $e->getCode());
    }

    // Conclude Uploaded File

    try {
      $conclude_file = $callApiService->conclude_file($token, $ciUploadId);
      $message = 'Your Upload Id is ' . $ciUploadId;
      $notifyService->sendNotification($email, $message);
      return new JsonResponse(['message' => $message], 200);
    } catch (\Exception $e) {
      return new JsonResponse(["message" => 'Something went wrong!'], $e->getCode());
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
   * @return Response
   */
  public function get_status(AuthService $authService, CallApiService $callApiService, Request $request): Response
  {

    //Email and password to generate JWT token 
    $email = $request->get('email');
    $password = $request->get('password');
    $ciUploadId = $request->get('ciUploadId');

    //Env Variables

    $vulnerabilities_value = $this->getParameter('app.vulnerabilities_value');

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
        $message = 'Total number of the vulnerabilities found is' . $status['vulnerabilitiesFound'];
        if ($vulnerabilities_value < $status['vulnerabilitiesFound']) {
        }
        // is completed
      } else {
        //On progress
      }
      return new JsonResponse(['status' => $status], 200);
    } catch (\Exception $e) {
      return new JsonResponse(["message" => 'Something went wrong!'], $e->getCode());
    }
  }
}
