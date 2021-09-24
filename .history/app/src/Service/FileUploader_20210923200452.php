<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Psr\Log\LoggerInterface;

class FileUploader
{
  private $logger;

  /**
   * __construct
   *
   * @param  mixed $logger
   * @return void
   */
  public function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }

  /**
   * upload
   *
   * @param  mixed $uploadDir
   * @param  mixed $file
   * @param  mixed $filename
   * @return void
   */
  public function upload($uploadDir, $file, $filename)
  {
    try {

      $file->move($uploadDir, $filename);
    } catch (FileException $e) {

      $this->logger->error('failed to upload image: ' . $e->getMessage());
      throw new FileException('Failed to upload file');
    }
  }
}
