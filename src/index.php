<?php
declare(strict_types=1);

use Core\Routing;

function myAutoloader(string $class): void
{
    $className = substr($class, strpos($class, '\\') + 1);
    $classPath = "Core/" . $className . ".php";
    $classModel = "Models/" . $className . ".php";
    $classRepository = "Repository/" . $className . ".php";
    $classEntity = 'Entity/' . $className . '.php';
    $classForm = 'Form/' . $className . '.php';
    $classValueObject = 'ValueObject/' . $className . '.php';

    if (file_exists($classPath)) {
        include $classPath;
    } elseif (file_exists($classModel)) {
        include $classModel;
    } elseif (file_exists($classRepository)) {
        include $classRepository;
    } elseif (file_exists($classEntity)) {
        include $classEntity;
    } elseif (file_exists($classForm)) {
        include $classForm;
    } elseif (file_exists($classValueObject)) {
        include $classValueObject;
    }
}

// La fonction myAutoloader est lancé sur la classe appelée n'est pas trouvée
spl_autoload_register("myAutoloader");

// Récupération des paramètres dans l'url - Routing
$slug = explode("?", $_SERVER["REQUEST_URI"])[0];
$routes = Routing::getRoute($slug);
$container = [];
$container['config'] = require 'config/global.php';
$container += require 'config/di.global.php';

// Vérifie l'existence du fichier et de la classe pour charger le controlleur
if (file_exists($routes['controllerPath'])) {
    include $routes['controllerPath'];
    if (class_exists('\\Controllers\\' . $routes['controller'])) {
        //instancier dynamiquement le controller
        $cObject = $container['Controllers\\' . $routes['controller']]($container);
        //vérifier que la méthode (l'action) existe
        if (method_exists($cObject, $routes['action'])) {
            //appel dynamique de la méthode
            $action = $routes['action'];
            $cObject->$action();
        } else {
            die("La methode " . $routes['action'] . " n'existe pas");
        }
    } else {
        die("La class controller " . $routes['controller'] . " n'existe pas");
    }
} else {
    die("Le fichier controller " . $routes['controller'] . " n'existe pas");
}
