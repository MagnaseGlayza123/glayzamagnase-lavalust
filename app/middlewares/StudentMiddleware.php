<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle($next)
    {
        $_SESSION['student_access'] = true;

        if ($_SESSION['student_access'] === true) {
            return $next();
        }

        echo "<h2 style='font-family: Arial; color: #5d4037; text-align: center; margin-top: 100px;'>
                ☕ Coffee Access Required
              </h2>
              <p style='font-family: Arial; text-align: center; color: #795548;'>
                Please visit Glayza's Coffee Student Hub first to access this profile.
              </p>";

        exit;
    }
}