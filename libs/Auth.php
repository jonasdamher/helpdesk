<?php

declare(strict_types=1);

class Auth
{
    private static array $path = [
        'controller' => '',
        'action' => ''
    ];

    public static function path(array $path): void
    {
        self::$path['controller'] = $path[0];
        self::$path['action'] = $path[1];
    }

    public static function check(): void
    {
        if (isset($_SESSION['user_init'])) {
            Utils::redirection('User/account');
        }
    }

    public static function access(): void
    {
        try {
            $access = false;

            if (array_key_exists(self::$path['controller'], $_SESSION['permission_page'])) {

                $pages = $_SESSION['permission_page'][self::$path['controller']];

                foreach ($pages as $page) {
                    if (self::$path['action'] == $page['action']) {
                        $access = true;
                    }
                }
            }

            if (!$access) {
                throw new Exception();
            }
        } catch (Exception $e) {
           Utils::redirection('error/401');
        }
    }
}
