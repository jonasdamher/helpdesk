<?php

declare(strict_types=1);

/**
 * Para administrar diferentes bases de datos.
 */
class DatabaseHandler
{

	private static array $credentials = [
		'helpdesk' => [
			'driver' => 'mysql',
			'dns' => 'localhost',
			'port' => 3306,
			'databaseName' => 'helpdeskdb',
			'charset' => 'utf8mb4',
			'userName' => 'root',
			'password' => ''
		]
	];

	protected static array $connections = [];

	protected static string $dbByDefault = 'helpdesk';

	/**
	 * Iniciar la conexión a la base de datos.
	 */
	protected static function connectionTo($db): object
	{
		try {
				
			$dns = self::$credentials[$db]['driver'] . ':host=' . self::$credentials[$db]['dns'] . '; 
			port=' . self::$credentials[$db]['port'] . '; 
			dbname=' . self::$credentials[$db]['databaseName'] . '; 
			charset=' . self::$credentials[$db]['charset'];

			$pdoconnections = new PDO($dns, self::$credentials[$db]['userName'], self::$credentials[$db]['password']);
			$pdoconnections->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $pdoconnections;
		} catch (PDOException $e) {
			exit('Error connect to database: ' . $e->getMessage());
		}
	}
}
