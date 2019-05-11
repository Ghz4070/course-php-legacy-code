<?php

namespace Models;

use PDO;

interface PdoInterface
{
    public function getPdo(): PDO;
}