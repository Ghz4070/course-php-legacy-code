<?php
declare(strict_types=1);

namespace Core;

use Models\RoutingInterface;

class Routing implements RoutingInterface
{
    public static $routeFile = 'routes.yml';

    public static function getRoute(string $slug): array
    {
        $routes = yaml_parse_file(self::$routeFile);
        if (isset($routes[$slug])) {
            if (empty($routes[$slug]['controller']) || empty($routes[$slug]['action'])) {
                die('Il y a une erreur dans le fichier routes.yml');
            }
            $controller = ucfirst($routes[$slug]['controller']) . 'Controller';
            $action = $routes[$slug]['action'] . 'Action';
            $controllerPath = 'Controller/' . $controller . '.php';
        } else {
            return ['controller' => null, 'action' => null, 'controllerPath' => null];
        }

        return ['controller' => $controller, 'action' => $action, 'controllerPath' => $controllerPath];
    }

    public static function getSlug(string $controller, string $action): ?string
    {
        $routes = yaml_parse_file(self::$routeFile);

        foreach ($routes as $slug => $controllerAndAction) {
            if (!empty($controllerAndAction['controller']) &&
                !empty($controllerAndAction['action']) &&
                $controllerAndAction['controller'] == $controller &&
                $controllerAndAction['action'] == $action) {
                return $slug;
            }
        }

        return null;
    }
}
