<?php

declare(strict_types=1);

/*
    Para recoger variables de entorno de un archivo .env.
*/
class Environment
{

    private static string $fileName = '.env';
    private static array $data = [];

    /**
     * Comprueba y lee el archivo .env de la raíz del proyecto 
     * y guarda toda la configuración en un array.
     */
    public static function init(): void
    {
        try {

            if (!file_exists(self::$fileName)) {
                throw new Exception('El archivo "' . self::$fileName . '" no existe.');
            }

            $readFile = file(
                self::$fileName,
                FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
            );

            foreach ($readFile as $line) {
                $separatePhrase = explode('=', $line);
                self::$data[$separatePhrase[0]] =  $separatePhrase[1];
            }
        } catch (Exception $e) {
            exit($e);
        }
    }

    /**
     * Devuelve el valor de un parámetro definido en el archivo .env.
     */
    public static function process(string $key): string
    {
        try {
            if (!array_key_exists($key, self::$data)) {
                throw new Exception('La variable de entorno "' . $key . '" no existe.');
            }
            return self::$data[$key];
        } catch (Exception $e) {
            exit('Variables de entorno: ' . $e);
        }
    }
}
