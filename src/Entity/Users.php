<?php
declare(strict_types=1);

namespace Entity;

use Models\UsersInterface;
use ValueObject\Identity;
use Repository\UsersRepository;

class Users implements UsersInterface
{
    private $userRepository;
    private $id = null;
    private $email;
    private $pwd;
    private $role = 1;
    private $status = 0;
    private $identity;

    public function __construct(UsersRepository $usersRepository, Identity $identity)
    {
        $this->userRepository = $usersRepository;
        $this->identity = $identity;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
        $this->userRepository->getOneBy(['id' => $id], true);
    }

    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    public function setPwd(string $pwd): void
    {
        $this->pwd = password_hash($pwd, PASSWORD_DEFAULT);
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPwd(): string
    {
        return $this->pwd;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}