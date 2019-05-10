<?php
declare(strict_types=1);

namespace Core;

use Models\ViewInterface;

class View implements ViewInterface
{
    private $view;
    private $template;
    private $data = [];

    public function __construct(string $view, string $template = 'back')
    {
        $this->setView($view);
        $this->setTemplate($template);
    }

    public function setView(string $view): void
    {
        $viewPath = 'views/' . $view . '.view.php';
        if (file_exists($viewPath)) {
            $this->view = $viewPath;
        } else {
            die("Attention le fichier view n'existe pas " . $viewPath);
        }
    }

    public function setTemplate(string $template): void
    {
        $templatePath = 'views/templates/' . $template . '.tpl.php';
        if (file_exists($templatePath)) {
            $this->template = $templatePath;
        } else {
            die("Attention le fichier template n'existe pas " . $templatePath);
        }
    }

    public function addModal(string $modal,array $config): void
    {
        $modalPath = 'views/modals/' . $modal . '.mod.php';
        if (file_exists($modalPath)) {
            include $modalPath;
        } else {
            die("Attention le fichier modal n'existe pas " . $modalPath);
        }
    }

    public function assign(string $key, array $value): void
    {
        $this->data[$key] = $value;
    }

    public function __destruct()
    {
        extract($this->data);
        include $this->template;
    }
}