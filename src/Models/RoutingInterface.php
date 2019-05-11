<?php

namespace Models;

interface RoutingInterface
{
    public static function getRoute(string $slug): array;

    public static function getSlug(string $controller, string $action): ?string;
}