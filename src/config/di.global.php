<?php
declare(strict_types=1);

use Core\BaseSQL;
use Entity\Users;
use Repository\UsersRepository;
use Controllers\PagesController;
use Controllers\UsersController;
use ValueObject\Identity;

return [
    BaseSQL::class => function ($container) {
        $host = $container['config']['database']['host'];
        $driver = $container['config']['database']['driver'];
        $name = $container['config']['database']['name'];
        $user = $container['config']['database']['user'];
        $password = $container['config']['database']['password'];

        $pdo = new BaseSQL($driver, $host, $name, $user, $password);
        return $pdo->getPdo();
    },
    Users::class => function ($container) {
        $baseSql = $container[BaseSQL::class]($container);
        $userRep = new UsersRepository($baseSql);
        $identity = new Identity();

        return new Users($userRep, $identity);
    },
    UsersController::class => function ($container) {
        $userModel = $container[Users::class]($container);
        $baseSql = $container[BaseSQL::class]($container);
        $userRep = new UsersRepository($baseSql);
        return new UsersController($userModel, $userRep);
    },
    PagesController::class => function ($container) {
        return new PagesController();
    }
];