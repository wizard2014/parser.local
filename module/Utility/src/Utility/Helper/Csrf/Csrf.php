<?php

namespace Utility\Helper\Csrf;

use Zend\Session\Container;

class Csrf
{
    static protected $session;

    /**
     * @param int $strong
     *
     * @return string
     */
    public static function generate($strong = 8)
    {
        self::$session = new Container('token');

        $token = self::pseudoBytes($strong);

        self::$session->offsetSet('token', $token);

        return $token;
    }

    /**
     * @param $token
     *
     * @return bool
     */
    public static function valid($token)
    {
        self::$session = new Container('token');

        $sessionToken = self::$session->offsetGet('token');

        if (!empty($token) && $token === $sessionToken) {
            return true;
        }

        return false;
    }

    /**
     * @param $strong
     *
     * @return string
     *
     * @todo change to PHP7 random_bytes/random_int
     */
    private static function pseudoBytes($strong)
    {
        $bytes = openssl_random_pseudo_bytes(16, $strong);

        return bin2hex($bytes);
    }
}
