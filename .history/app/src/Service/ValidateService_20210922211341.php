<?php

namespace App\Service;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ValidateService
{
  private $validator;

  public function __construct(ValidatorInterface $validator)
  {
    $this->validator = $validator;
  }

  public function validateRequest($email, $password)
  {
    $params = new Assert\Collection([
      $email => new Assert\Email(),
      $password => new Assert\NotBlank()
    ]);
    $validate = $this->validator->validate($params);
    return $params;
  }
}
