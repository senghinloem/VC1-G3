<?php
require_once "BaseController.php";

class LoginRegisterController extends BaseController
{
    public function login()
    {
        $this->view('auth/login', [], false); // Bypass layout for login
    }

    public function register()
    {
        $this->view('auth/register', [], false); // Bypass layout for register
    }

    public function error()
    {
        $this->view('errors/error');
    }
}