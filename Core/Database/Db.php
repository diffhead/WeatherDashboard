<?php namespace Core\Database;

use Exception;

use Interfaces\Database\Connection;

use Config\DatabaseConfig;

class Db
{
    const DRIVER_PGSQL  = 'pgsql';
    const DRIVER_MYSQL  = 'mysql';
    const DRIVER_SQLITE = 'sqlite';

    private static Connection $dbConnection;

    private static array      $dbDrivers = [
        'pgsql'  => '\\Core\\Database\\PgSQLConnection',
        'mysqli' => '\\Core\\Database\\MySQLConnection',
        'sqlite' => '\\Core\\Database\\SQLiteConnection'
    ];

    public static function getConnection(bool $autoConnection = true): Connection
    {
        if ( self::isConnectionExists() === false ) {
            self::createConnection(DatabaseConfig::get('driver'));
        }

        if ( $autoConnection && self::$dbConnection->isConnected() === false ) {
            $connectionUser = DatabaseConfig::get('username');
            $connectionPassword = DatabaseConfig::get('password');

            self::$dbConnection->connect($connectionUser, $connectionPassword);
        }

        return self::$dbConnection;
    }

    private static function isConnectionExists(): bool
    {
        return isset(self::$dbConnection);
    }

    public static function openConnection(): bool
    {
        $connectionDriver = DatabaseConfig::get('driver');
        $connectionUser = DatabaseConfig::get('username');
        $connectionPassword = DatabaseConfig::get('password');

        self::createConnection($connectionDriver);

        if ( self::$dbConnection->connect($connectionUser, $connectionPassword) === false ) {
            return false;
        }

        return true;
    }

    public static function createConnection(string $driver): void
    {
        if ( self::isDriverImplementationExists($driver) === false ) {
            throw new Exception("Connection implementation for driver '$driver' not exists");
        }

        $connectionClass = self::$dbDrivers[$driver];
        $connectionDatabase = DatabaseConfig::get('database');
        $connectionHost = DatabaseConfig::get('host');
        $connectionPort = DatabaseConfig::get('port');

        self::$dbConnection = new $connectionClass($connectionDatabase, $connectionHost, $connectionPort);
    }

    private static function isDriverImplementationExists(string $driver): bool
    {
        return isset(self::$dbDrivers[$driver]);
    }

    public static function closeConnection(): bool
    {
        if ( self::isConnectionExists() ) {
            return self::$dbConnection->disconnect();
        }

        return false;
    }
}
