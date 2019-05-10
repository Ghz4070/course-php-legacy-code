<?php

namespace Models;

class IdentityInterface
{
    public function setFirstname(string $firstname): void;

    public function setLastname(string $lastname): void;

    public function getFirstname(): string;

    public function getLastname(): string;

}