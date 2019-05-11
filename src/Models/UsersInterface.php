<?php

namespace Models;

interface UsersInterface
{
    public function setId(int $id): void;

    public function setEmail(string $email): void;

    public function setPwd(string $password): void;

    public function setRole(string $role): void;

    public function setStatus(string $status): void;

    public function getId(): ?int;

    public function getEmail(): string;

    public function getPwd(): string;

    public function getRole(): int;

    public function getStatus(): int;
}