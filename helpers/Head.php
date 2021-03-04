<?php

declare(strict_types=1);

/**
 * Clase para añadir el título a la página 
 * y añadir información a las meta etiquetas HTML
 */
class Head
{
	private static string $lang = 'es';
	private static string $title = '';
	private static string $canonical = '';
	private static string $robots = 'noindex, nofollow';
	private static string $description = 'helpdesk, administrador de incidencias.';
	private static string $keyWords = 'helpdesk, incidencias informaticas';

	private static array $linksCss = [];
	private static array $linksJs = [];

	/**
	 * Establecer idioma de página web.
	 */
	public static function lang(string $lang): void
	{
		self::$lang = $lang;
	}

	/**
	 * Devuelve el idioma de página web.
	 */
	public static function getLang(): string
	{
		return self::$lang;
	}

	/**
	 * Establecer título de página web.
	 */
	public static function title(string $title): void
	{
		self::$title = $title . ' - ';
	}

	/**
	 * Devuelve el título de página web.
	 */
	public static function getTitle(): string
	{
		return self::$title;
	}

	/**
	 * Establecer url canónica de página web.
	 */
	public static function caconical(string $url): void
	{
		self::$canonical = $url;
	}

	/**
	 * Devuelve url canónica de página web.
	 */
	public static function getCaconical(): string
	{
		return self::$canonical;
	}

	/**
	 * Establecer robots de página web.
	 */
	public static function robots(string $robots): void
	{
		self::$robots = $robots;
	}

	/**
	 * Devuelve parámetros de robots de página web.
	 */
	public static function getRobots(): string
	{
		return self::$robots;
	}

	/**
	 * Establecer descripción de página web.
	 */
	public static function description(string $description): void
	{
		self::$description = $description;
	}

	/**
	 * Devuelve la descripción de página web.
	 */
	public static function getDescription(): string
	{
		return self::$description;
	}

	/**
	 * Añadir keywords al head de la página web.
	 */
	public static function keyWords($keywords, $referenceArray = null): void
	{
		if (is_array($keywords)) {
			if (count($keywords) > 0) {
				$keys = [];

				foreach ($keywords as $key) {
					array_push($keys, ',' . $key[$referenceArray]);
				}

				$keys = implode('', $keys);

				if (substr($keys, 0, 1) == ',') {
					$keys = substr($keys, 1);
				}

				$keywords = $keys;
			} else {
				$keywords = '';
			}
		}

		self::$keyWords = $keywords;
	}

	/**
	 * Devuelve un array con todas las keywords de la página web.
	 */
	public static function getKeyWords(): string
	{
		return self::$keyWords;
	}

	/**
	 * Añadir un nuevo archivo CSS al head de la página web.
	 */
	public static function css($fileName): void
	{
		if (is_array($fileName)) {
			self::$linksCss = array_merge(self::$linksCss, $fileName);
		} else {
			array_push(self::$linksCss, $fileName);
		}
	}

	/**
	 * Devuelve un array con todos los archivos CSS del head.
	 */
	public static function getLinksCss(): array
	{
		return self::$linksCss;
	}

	/**
	 * Añadir un nuevo archivo JavaScript al head de la página web.
	 */
	public static function js($fileName): void
	{
		if (is_array($fileName)) {
			self::$linksJs = array_merge(self::$linksJs, $fileName);
		} else {
			array_push(self::$linksJs, $fileName);
		}
	}

	/**
	 * Devuelve un array con todos los archivos JavaScript del head.
	 */
	public static function getLinksJs(): array
	{
		return self::$linksJs;
	}
}
