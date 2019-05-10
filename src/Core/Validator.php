<?php
declare(strict_types=1);

namespace Core;

use Models\ValidatorInterface;

class Validator implements ValidatorInterface
{
    public $errors = [];

    public function __construct(array $config, array $data)
    {
        if (count($data) != count($config["data"])) {
            die("Tentative : faille XSS");
        }

        foreach ($config["data"] as $name => $info) {
            if (!isset($data[$name])) {
                die("Tentative : faille XSS");
            } else {
                if (($info["required"]??false) && !self::notEmpty($data[$name])) {
                    $this->errors[]=$info["error"];
                }


                if (isset($info["minlength"]) && !self::minLength($data[$name], $info["minlength"])) {
                    $this->errors[]=$info["error"];
                }

                if (isset($info["maxlength"]) && !self::maxLength($data[$name], $info["maxlength"])) {
                    $this->errors[]=$info["error"];
                }

                if ($info["type"]=="email" && !self::checkEmail($data[$name])) {
                    $this->errors[]=$info["error"];
                }

                if (isset($info["confirm"]) && $data[$name] != $data[$info["confirm"]]) {
                    $this->errors[]=$info["error"];
                } elseif ($info["type"]=="password" && !self::checkPassword($data[$name])) {
                    $this->errors[]=$info["error"];
                }
            }
        }
    }

    public static function notEmpty(string $string): bool
    {
        return !empty(trim($string));
    }

    public static function minLength(string $string, int $length): bool
    {
        return strlen(trim($string))>=$length;
    }

    public static function maxLength(string $string, int $length): bool
    {
        return strlen(trim($string))<=$length;
    }

    public static function checkEmail(string $string):  string
    {
        return filter_var(trim($string), FILTER_VALIDATE_EMAIL);
    }

    public static function checkPassword(string $string): bool
    {
        return (
                    preg_match("#[a-z]#", $string) &&
                    preg_match("#[A-Z]#", $string) &&
                    preg_match("#[0-9]#", $string));
    }
}