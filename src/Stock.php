<?php

/*
 * This file is part of the PHPallas package.
 *
 * (c) Sina Kuhestani <sinakuhestani@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPallas\Buffer;

use PHPallas\Utilities\ArrayUtility;

/**
 * Class Stock
 *
 * This class implements a singleton pattern to manage a collection of data
 * associated with different scopes. It allows for setting, getting, and clearing
 * data entries.
 *
 * @package PHPallas\Buffer
 */
final class Stock
{
    /**
     * Separator used in the scope key.
     *
     * @var string
     */
    const separator = ".";

    /**
     * The single instance of the Stock class.
     *
     * @var Stock|null
     */
    private static $instance = NULL;

    /**
     * Array to hold data entries.
     *
     * @var array
     */
    private $data = [];

    /**
     * Stock constructor is private to prevent direct instantiation.
     */
    private function __construct()
    {
    }

    /**
     * Gets the singleton instance of the Stock class.
     *
     * @return Stock The instance of the Stock class.
     */
    public static function getInstance()
    {
        if (null === static::$instance)
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * Retrieves a value from the data array based on the name and scope.
     *
     * @param string $name The name of the entry to retrieve.
     * @param string $scope The scope under which the entry is stored (default is "main").
     * @return mixed|null Returns the value associated with the name and scope, or null if not found.
     */
    public function get($name, $scope = "main")
    {
        return ArrayUtility::get(
            $this->data,
            static::scopeKey($scope) . static::separator . $name
        );
    }

    /**
     * Sets a value in the data array under the specified name and scope.
     *
     * @param string $name The name of the entry to set.
     * @param mixed $value The value to store.
     * @param string $scope The scope under which to store the entry (default is "main").
     */
    public function set($name, $value, $scope = "main")
    {
        ArrayUtility::set(
            $this->data,
            static::scopeKey($scope) . static::separator . $name,
            $value
        );
    }

    /**
     * Drops an item from buffer
     * @param string $name
     * @param string $scope
     * @return void
     */
    public function unset($name, $scope = "main")
    {
        $key = static::scopeKey($scope) . static::separator . $name;
        ArrayUtility::dropKey($this->data, $key);
    }

    /**
     * Clears all entries from the data array.
     */
    public function clearAll()
    {
        $this->data = [];
    }

    /**
     * Generates a unique scope key based on the provided scope string.
     *
     * @param string $scope The scope string to hash.
     * @return string The generated scope key.
     */
    private static function scopeKey($scope)
    {
        return "scope_" . sha1($scope);
    }
}