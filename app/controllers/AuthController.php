<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->library('session');
    }

    public function login()
    {
        if ($this->session->has_userdata('user_id')) {
            redirect('/products');
            exit;
        }

        $this->call->view('login');
    }

    public function authenticate()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === 'admin123') {

            $this->session->set_userdata('user_id', 1);
            $this->session->set_userdata('username', 'admin');

            redirect('/products');
            exit;
        }

        $this->call->view('login', [
            'error' => 'Invalid username or password.'
        ]);
    }

    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');

        redirect('/login');
        exit;
    }
}

?>
