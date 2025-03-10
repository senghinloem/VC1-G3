<?php

require_once "Models/UserModel.php";
class UserController extends BaseController
{
    private $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }


}

?>