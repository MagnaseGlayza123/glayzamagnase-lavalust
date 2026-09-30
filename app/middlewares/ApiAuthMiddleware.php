<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiAuth
{
    protected $refreshTokenModel;

    public function __construct()
    {
        $this->refreshTokenModel = null;
    }

    /**
     * Get Bearer token from request.
     */
    public function getBearerToken()
    {
        $authorization = '';

        // Try getallheaders()
        if (function_exists('getallheaders')) {
            $headers = getallheaders();

            foreach ($headers as $key => $value) {
                if (strtolower($key) === 'authorization') {
                    $authorization = $value;
                    break;
                }
            }
        }

        // Apache / PHP fallback
        if (!$authorization && isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        }

        // Another Apache fallback
        if (!$authorization && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $authorization = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        if (!$authorization) {
            return null;
        }

        if (!preg_match('/Bearer\s+(.+)/i', $authorization, $matches)) {
            return null;
        }

        $token = trim($matches[1]);

        return $token !== '' ? $token : null;
    }
}
?>