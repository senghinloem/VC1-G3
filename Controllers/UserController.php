<?php

require_once "Models/UserModel.php";
class UserController extends BaseController
{
    private $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function user()
    {
        $user = $this->user->getUsers();
        $this->view('users/user', ['users' => $user]);
    }

    public function create()
    {
        $this->view('users/create_user');
    }

    public function store() {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $phone = $_POST['phone'];

        $this->user->addUser($first_name, $last_name, $email, $password, $role, $phone);
        header("Location: /users");
    }

    public function edit($id)
    {
        $user = $this->user->getUserById($id);
        $this->view('users/edit_user', ['user' => $user]);
    }

    public function update($user_id)
    {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $phone = $_POST['phone'];

        $this->user->updateUser($user_id, $first_name, $last_name, $email, $password, $role, $phone);
        header("Location: /users");
    }

    public function destroy($user_id)
    {
        $this->user->deleteUser($user_id);
        header("Location: /users");
    }


}

?>