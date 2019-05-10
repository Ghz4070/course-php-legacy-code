<?php

namespace Models;


interface PdoInterface
{
    public function getPdo(): \PDO;
}