<?php

namespace Api\Repository;

use PDO;
use Exception;

class DB
{
    /**
     * @var ?DB
     */
    private static $instance = null;
    
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * The constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    private function __construct() {
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        
        $dsn = sprintf($_ENV['DB_DSN'], $_ENV['DB_HOST'], $_ENV['DB_DATABASE'], $_ENV['DB_PORT']);
        $this->connection = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $options);
    }

    /**
     * Based on 'Singleton pattern' this function will always return a single instance.
     *
     * @return DB
     */
    public static function getInstance(): DB
    {
        if(self::$instance === null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }

    /**
     * Prevent cloning.
     *
     * @return void
     */
    protected function __clone() : void { }

    /**
     * Prevent restore from strings.
     *
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }
}