<?php
declare(strict_types=1);

namespace ValueObject;

class Identity
{
    public $lastname;
    public $firstname;

    public function __construct()
    {

    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }
}