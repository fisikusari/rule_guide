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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
   * @param  mixed $validator
   * @param  mixed $request
   * @return Response
   */

  public function rule_engine(AuthService $authService, CallApiService $callApiService, string $uploadDir, FileUploader $uploader, NotifyService $notifyService, ValidatorInterface $validator, Request $request): Response
  {

    $email = $request->get('email');
    $password = $request->get('password');

    $emailConstraint = new Assert\Email();
    $emailConstraint->message = 'Invalid email address';

    // use the validator to validate the value
    $errors = $validator->validate(
      $email,
      $emailConstraint
    );

    if (count($errors)) {
      return new JsonResponse(["message" => $errors[0]->getMessage()], 422);
    }

    // Required field 

    $repositoryName = $request->get('repositoryName');
    $commitName = $request->get('commitName');

    // Try to login and generate JWT token

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
      $filePath = $uploadDir . '/' . $filename;
      // Upload file for test

      try {
        $upload_file_response = $callApiService->upload_file($token, $filePath, $repositoryName, $commitName);
        $ciUploadId = (string)$upload_file_response['ciUploadId'];
      } catch (\Exception $e) {
        $message = "The upload is not completed";
        return new JsonResponse(["message" => $message], $e->getCode());
      }

      // Conclude Uploaded File

      try {
        $callApiService->conclude_file($token, $ciUploadId);
        $notifyService->sendNotification($email, 'Your Upload Id  for dependency ' . $filename . ' is ' . $ciUploadId);
      } catch (\Exception $e) {
        return new JsonResponse(["message" => 'Something went wrong!'], $e->getCode());
      }
    }
    return new JsonResponse(['message' => 'The uploading process is completed'], 200);
  }


  /**
   * get_status
   *
   * @Route("/get-status", name="rule_engine_status")
   *
   * @param  mixed $authService
   * @param  mixed $callApiService
   * @param  mixed $notifyService
   * @param  mixed $validator
   * @param  mixed $request
   * @return Response
   */

  public function get_status(AuthService $authService, CallApiService $callApiService, NotifyService $notifyService, ValidatorInterface $validator, Request $request): Response
  {


    $email = $request->get('email');
    $password = $request->get('password');

    $emailConstraint = new Assert\Email();

    $emailConstraint->message = 'Invalid email address';

    // use the validator to validate the value
    $errors = $validator->validate(
      $email,
      $emailConstraint
    );
    if (count($errors)) {
      return new JsonResponse(["message" => $errors[0]->getMessage()], 422);
    }

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
      $message = $status['progress'] == 100 ? 'Total number of the vulnerabilities found is ' . $status['vulnerabilitiesFound'] : 'The upload is in progress';

      if ($upload_in_progress) {
        $notifyService->sendNotification($email, $message);
      }

      return new JsonResponse(['message' => $message], 200);
    } catch (\Exception $e) {
      $message = 'The upload has failed';
      if ($upload_failed) {
        $notifyService->sendNotification($email, $message);
      }
      return new JsonResponse(["message" => $message], $e->getCode());
    }
  }
}
