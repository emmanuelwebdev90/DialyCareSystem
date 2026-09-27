<?php

require_once('./models/users.php');
require_once('./models/pacientes.php');

class PacienteController extends Pacientes
{
    private String $route_view = "./views/users";
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->id_usuario = $_REQUEST['usuario'];
        $user = new Users();
        $user->id=$this->id_usuario;
        $nombre = $user->getUserById();
        
        require_once("{$this->route_view}/pacientes_form.php");
    }
}
