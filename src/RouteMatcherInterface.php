<?php

namespace App;


interface RouteMatcherInterface
{

    public function match(string $path, string $pattern): array;
}