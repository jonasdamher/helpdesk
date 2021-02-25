<?php

declare(strict_types=1);

/**
 * Clase para establecer conexión a la base de datos.
 */
class Database extends DatabaseHandler
{
    /**
     * Conectar a la DB.
     * @param string $db nombre de base de datos.
     * @return object Conexión PDO a la base de datos.
     */
    public static function connect($db = null): object
    {
        $db = is_null($db) ? parent::$dbByDefault : $db;

        if (!key_exists($db, parent::$connections) || is_null(parent::$connections[$db])) {
            parent::$connections[$db] = parent::connectionTo($db);
        }

        return parent::$connections[$db];
    }

    /**
     * Desconectar de la DB.
     * @param string $db nombre de base de datos.
     */
    public static function disconnect($db = null)
    {
        $db = is_null($db) ? parent::$dbByDefault : $db;

        parent::$connections[$db] = null;
    }


    /**
     * Desconectar todas las conexiones a DDBB.
     */
    public static function disconnectAll()
    {
        parent::$connections = [];
    }
}
