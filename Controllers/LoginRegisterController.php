<?php

class LoginRegisterController extends BaseController
{
    public function login () 
    {
        $this->view("auth/login");
    }

    public function register() 
    {
        $this->view("auth/register");
    }
}

?>