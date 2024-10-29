<?php
namespace Palmo\Source;
require('Config.php');

use PDO;

class Db
{
    /** @var PDO */
    private PDO $handler;

    public function __construct()
    {
        $config = new Config();
        $dbConfig = $config->get('db');

        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->handler = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], $opt);
    }

    public function getHandler(): PDO
    {
        return $this->handler;
    }
}