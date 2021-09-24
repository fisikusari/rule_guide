<?php

namespace App\Service;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ValidateService
{
  private $validator;

  public function __construct(HValidatorInterface $validator)
  {
    $this->validator = $validator;
  }

  public function validateRequest($email, $password)
  {
    $constraint = new Assert\Collection([
      $email => new Assert\Email()
    ]);
  }
}
