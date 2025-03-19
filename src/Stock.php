<?php

/*
 * This file is part of the PHPallas package.
 *
 * (c) Sina Kuhestani <sinakuhestani@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPallas\Buffer;

use PHPallas\Utilities\ArrayUtility;

/**
 * Summary of Stock
 */
final class Stock
{
    private const separator = ".";

    private static ? Stock $instance = NULL;

    private array $data = [];

    private array $helpers = [];

    private function __construct()
    {
    }

    public static function getInstance(): static
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function get(string $name, string $scope = "main"): mixed
    {
        return ArrayUtility::get($this->data, static::scopeKey($scope) . static::separator . $name);
    }

    public function set(string $name, mixed $value, string $scope = "main")
    {
        ArrayUtility::set($this->data, static::scopeKey($scope) . static::separator . $name, $value);
    }

    public function register(string $name, callable $function, string $scope = "main")
    {
        ArrayUtility::set($this->helpers, static::scopeKey($scope) . static::separator . $name, $function);
    }

    // public function unregister(string $name, string $scope = "main"): void
    // {
    //     if (TRUE === isset($this->helpers[static::scopeKey($scope). static::separator . $name])) {
    //         unset($this->helpers[static::scopeKey($scope) . static::separator .  $name]);
    //     }
    // }
    public function __call($method, $args = []): mixed
    {
        if (isset($args["scope"])) {
            $scope = $args["scope"];
            unset($args["scope"]);
        }
        else if (isset($args[0])) {
            $scope = $args[0];
            unset($args[0]);
        }
        else {
            $scope = "main";
        }

        if (TRUE === isset($this->helpers[static::scopeKey($scope) . static::separator . $method])) {
            return call_user_func($this->helpers[static::scopeKey($scope) . static::separator . $method], $args);
        }
        return NULL;
    }

    public function clearAll(): void
    {
        $this->data = [];
    }

    private static function scopeKey (string $scope): string
    {
        return "scope_" . sha1($scope);
    }
}