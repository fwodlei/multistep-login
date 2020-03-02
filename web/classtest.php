<?php

class User
{
  private $name;
  private $email;

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($newEmail)
  {
    if (filter_var($newEmail, FILTER_VALIDATE_EMAIL) !== false) {
      $this->email = $newEmail;
      return true;
    }
    return false;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName($newName)
  {
    if (filter_var($newName, FILTER_DEFAULT) !== false) {
      $this->name = $newName;
      return true;
    }
    return false;
  }
}