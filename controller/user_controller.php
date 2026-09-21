<?php

require_once './models/users.php';
require_once './models/roles.php';
class UserController extends Users
{
    private String $route_view = "./views/users";
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index_users()
    {

        $users = $this->list_users();
        $roles = new Roles();
        $route_full = "{$this->route_view}/users.php";
        require_once($route_full);
    }
    public function list_users()
    {
        $users = $this->readAll();
        return ($users);
    }
    public function get_user_by_id()
    {
        if (isset($_REQUEST['id'])) {
            $this->id = $_REQUEST['id'];
            $user = $this->getUserById();
            print_r($user);
        } else {
            die("User ID not provided.");
        }
    }
    public function get_user_by_email()
    {
        if (isset($_REQUEST['email'])) {
            $email = $_REQUEST['email'];
            $user = $this->getUserByEmail($email);
            print_r($user);
        } else {
            die("User email not provided.");
        }
    }

    public function form_create_user()
    {
        $rol = new Roles();
        $roles = $rol->getAll();
        //print_r($roles);
        // Display the form for creating a new user
        require_once './views/users/user_form.php';
    }
   
    public function create_user()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['password_hash'] != $_POST['password']) {
                $message = ['type' => 'alert', 'message' => 'Password No Coincide', 'class' =>'a-danger'];
               
                header("location: index.php?controller=user&action=form_create_user&message={$message['message']}&cls={$message['class']}");
            } else {
                try {


                    $this->nombre_completo = $_POST['nombre_completo'];
                    $this->email = $_POST['email'];
                    $this->password_hash = $_POST['password_hash'];
                    $this->rol_id = $_POST['rol_id'];
                    $this->activo = $_POST['activo'];
                    $this->createUser();
                    $message = ['type' => 'alert', 'message' => 'Usuario creado', 'class' =>'a-success'];
               
                    header("location: index.php?controller=user&action=form_create_user&message={$message['message']}&cls={$message['class']}");
                    //echo "User created successfully."; // change later for a view
                } catch (Exception $e) {
                    die("Error creating user: " . $e->getMessage());
                }
            }
        } else {
            die("Invalid request method. Please use POST.");
        }
    }
}
