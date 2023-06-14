<?php

namespace Hetic\ReshomeApi\Database;
class PDOFactory
{
    private static string $dsn;
    private static string $username;
    private static string $password;

    public function __construct(string $configFilePath)
    {
        $config = $this->loadConfig($configFilePath);

        $this::$dsn = 'mysql:dbname=' . $config['dbname'] . ';host=' . $config['host'];
        $this::$username = $config['username'];
        $this::$password = $config['password'];
    }

    private function loadConfig(string $configFilePath) : array
    {
        $config = [];
        if (file_exists($configFilePath)) {
            $configContent = file_get_contents($configFilePath);
            $config = yaml_parse($configContent);
        } else {
            http_response_code(500);
        }

        return $config;
    }

    private static function getMysqlConnection(): \PDO
    {
        try {
            $db = new \PDO(self::$dbname, self::$host, self::$username, self::$password);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $exception) {
            ob_start();
            ?>
            <p><?= $exception->getMessage(); ?></p>
            <?php
            echo ob_get_clean();
        }
        return $db;
    }
    public function getConnection(): \PDO
    {
        return self::getMysqlConnection();
    }
}

