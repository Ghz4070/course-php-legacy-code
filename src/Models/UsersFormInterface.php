<?php declare(strict_types=1);

namespace Models;

interface UsersFormInterface
{
    public function getRegisterForm(): array;

    public function getLoginForm(): array;
}