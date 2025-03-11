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
        $users = $this->user->getUsers();
        $this->view('users/user', ['users' => $users]);
    }

    public function create()
    {
        $this->view('users/create_user');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $phone = $_POST['phone'];

            $this->user->addUser($first_name, $last_name, $email, $password, $role, $phone);
            header("Location: /users");
            exit();
        }
    }

    public function edit($id)
    {
        $user = $this->user->getUserById($id);
        $this->view('users/edit_user', ['user' => $user]);
    }

    public function update($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Ensure the correct request type
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $phone = $_POST['phone'];

            $this->user->updateUser($user_id, $first_name, $last_name, $email, $password, $role, $phone);
            header("Location: /users");
            exit();
        }
    }

    public function destroy($user_id)
    {
        $this->user->deleteUser($user_id); // This will call the deleteUser method from UserModel
        header("Location: /users"); // Redirect after deletion
        exit();
    }

    public function authenticate() {
        session_start();
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        
        // Correct object reference for the model
        $user = $this->user->getUserByEmail($email); 
    
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_role'] = $user['role'];
            $this->redirect("/users");
        } else {
            header("Location: /users/login-error");
            exit();
        }    
    }
    

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        $this->redirect("/");
    }

    public function loginError() {
        $this->view('login_error');
    }
    
}

    

?>

    