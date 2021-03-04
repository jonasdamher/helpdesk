<?php

declare(strict_types=1);

/**
 * Para administrar diferentes bases de datos.
 */
class DatabaseHandler
{
	private static array $credentials = [];
	protected static array $connections = [];

	/**
	 * Recoge las credenciales para las conexiones 
	 * a las DB mediante un archivo .env.
	 */
	private static function credentials(): void
	{

		$total = Environment::process('DB_TOTAL');
		for ($i = 1; $i <= $total; $i++) {
			self::$credentials[Environment::process('DB_ALIAS' . $i)] = [
				'driver' =>  Environment::process('DB_DRIVER' . $i),
				'dns' =>  Environment::process('DB_DNS' . $i),
				'port' =>  Environment::process('DB_PORT' . $i),
				'databaseName' =>  Environment::process('DB_NAME' . $i),
				'charset' =>  Environment::process('DB_CHARSET' . $i),
				'userName' =>  Environment::process('DB_USER' . $i),
				'password' =>  Environment::process('DB_PASS' . $i)
			];
		}
	}

	/**
	 * Iniciar la conexión a la base de datos.
	 */
	protected static function connectionTo($db): object
	{
		try {
			if (!count(self::$credentials)) {
				self::credentials();
			}

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
