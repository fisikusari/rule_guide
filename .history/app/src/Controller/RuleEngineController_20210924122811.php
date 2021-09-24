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
  public function some_method($i)
  {
    return new JsonResponse($i);
  }
  public function rule_engine(AuthService $authService, CallApiService $callApiService, string $uploadDir, FileUploader $uploader, NotifyService $notifyService, Request $request): Response
  {
    // Get file from request and upload on uploadDir folder.
    // $file = $request->files->get('file');
    // $filename = $file->getClientOriginalName();
    // $uploader->upload($uploadDir, $file, $filename);
    // $file_name = $uploadDir . '/' . $filename;

    // //Email and password to generate JWT token 
    // $email = $request->get('email');
    // $password = $request->get('password');

    // // Required field 
    // $repositoryName = $request->get('repositoryName');
    // $commitName = $request->get('commitName');

    // // Try to login and generate JWT token
    // try {
    //   $auth = $authService->login($email, $password);
    //   $token = $auth['token'];
    // } catch (\Exception $e) {
    //   return new JsonResponse(["message" => "The credentials used for the login requests towards the external api are not okay!"], $e->getCode());
    // }
    // // Upload file for test
    // try {
    //   $upload_file_response = $callApiService->upload_file($token, $file_name, $repositoryName, $commitName);
    //   $upload_in_progress = $this->getParameter('app.upload_in_progress');
    //   $ciUploadId = (string)$upload_file_response['ciUploadId'];
    // } catch (\Exception $e) {
    //   $message = "The upload is not completed";
    //   return new JsonResponse(["message" => $message], $e->getCode());
    // }

    // // Conclude Uploaded File

    // try {
    //   $conclude_file = $callApiService->conclude_file($token, $ciUploadId);
    // } catch (\Exception $e) {
    //   return new JsonResponse(["message" => 'Something went wrong!'], $e->getCode());
    // }

    // try {
    //   $status = $callApiService->get_status($token, $ciUploadId);
    //   $vulnerabilities_value = $this->getParameter('app.vulnerabilities_value');
    //   return new JsonResponse(['status' => $status], 200);
    // } catch (\Exception $e) {
    //   return new JsonResponse(["message" => 'Something went wrong!'], $e->getCode());
    // }
  }
}

// if ($status['vulnerabilitiesFound'] > $vulnerabilities_value) {
//   $message = "The number of vulnerabilities found is" . $status['vulnerabilitiesFound'];
//   $notifyService->sendNotification($email, $message);
// }
  // if ($upload_in_progress) {
      //   $message = "The uploading has started";
      //   $notifyService->sendNotification($email, $message);
      // }
// $output  = $this->somethingToTest();
// $progressBar = new ProgressBar($output, 100);

// starts and displays the progress bar
// $progressBar->start();

// $i = 0;
// while ($i++ < 100) {
//   // ... do some work

//   // advances the progress bar 1 unit
//   $progressBar->advance();

//   // you can also advance the progress bar by more than 1 unit
//   // $progressBar->advance(3);
// }
// // return new JsonResponse($i);
// // ensures that the progress bar is at 100%
// $progressBar->finish();

  // public function somethingToTest()
  // {
  //   return new JsonResponse('testing');
  // }