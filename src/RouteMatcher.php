<?php

namespace App;


class RouteMatcher implements RouteMatcherInterface
{
    public function match(string $path, string $pattern): array
    {
        $patternParts = explode('/', $pattern);
        $pathParts    = explode('/', $path);
        $arguments    = [];
        foreach ($patternParts as $position => $patternPart) {
            if (strpos($patternPart, '{') !== false && isset($pathParts[$position])) {
                $arguments[] = $patternParts[$position] = $pathParts[$position];
            }
        }

        if ($patternParts === $pathParts) {
            return $arguments;
        }

        return [];
    }
}