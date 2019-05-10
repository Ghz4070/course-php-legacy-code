<?php

namespace Models;

interface ValidatorInterface
{
    public static function checkPassword(string $string): bool;

    public static function checkEmail(string $string): string;

    public static function notEmpty(string $string): bool;

    public static function minLength(string $string, int $length): bool;

    public static function maxLength(string $string, int $length): bool;
}