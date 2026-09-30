s<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    public function handle($next)
    {
        $session = new Session();

        if ($session->has_userdata('user_id')) {
            return $next();
        }

        redirect('/login');
        exit;
    }
}

?>
