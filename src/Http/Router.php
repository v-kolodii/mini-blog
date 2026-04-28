<?php

declare(strict_types=1);

namespace App\Http;

class Router
{
    /** @var array<string, callable> */
    private array $routes = [];

    /** @var callable|null */
    private $notFoundHandler = null;

    public function get(string $pattern, callable $handler): void
    {
        $this->routes[$pattern] = $handler;
    }

    public function setNotFoundHandler(callable $handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function dispatch(string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        $pathParts = explode('/', trim($path, '/'));

        foreach ($this->routes as $pattern => $handler) {
            $patternParts = explode('/', trim($pattern, '/'));

            if (count($pathParts) !== count($patternParts)) {
                continue;
            }

            $args = [];
            $match = true;

            foreach ($patternParts as $i => $part) {
                if (str_starts_with($part, '{') && str_ends_with($part, '}')) {
                    $args[] = $pathParts[$i];
                } elseif ($part !== $pathParts[$i]) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                $handler(...$args);

                return;
            }
        }

        $this->handleNotFound();
    }

    private function handleNotFound(): void
    {
        http_response_code(404);
        if (is_callable($this->notFoundHandler)) {
            ($this->notFoundHandler)();
        } else {
            echo '404 Not Found';
        }
    }
}
