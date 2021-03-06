<?php
declare(strict_types=1);

namespace Controllers;

use Core\View;

class PagesController
{
    public function defaultAction(): void
    {
        $view = new View("homepage", "back");
        $view->assign("pseudo", "prof");
    }
}