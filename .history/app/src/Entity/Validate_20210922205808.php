<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Validate
{
  /**
   * @Assert\NotBlank
   */
  private $email;
}
