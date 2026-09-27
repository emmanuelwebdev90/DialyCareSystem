<?php
require_once './core/crud.php';

class Pacientes extends CRUD {
    public function __construct(
        public  $id='0',
        public $id_usuario='0',
        public $fecha_naciemiento='',
        public $tipo_dialisis='', 
        public $fecha_inicio_tratamiento='',
        public  $medico_responsable=""
    ) {
        parent::__construct('roles');
    }

    public function createPaciente(){
        $columns = "id_usuario, fecha_nacimiento, tipo_dialisis, fecha_inicio_tratamiento, medico_responsable";
        $values = ":id_usuario, :fecha_nacimiento, :tipo_dialisis, :fecha_inicio_tratamiento, :medico_responsable";
        $data = [
            ':id_usuario'=> $this->id_usuario,
            ':fecha_nacimiento'=>$this->fecha_naciemiento,
            ':tipo_dialisis'=>$this->tipo_dialisis,
            ':fecha_inicio_tratamiento'=>$this->fecha_inicio_tratamiento,
            ':medico_responsable'=>$this->medico_responsable
        ];
        $this->create($columns, $values, $data);
    }
    

    public function getRoleById(mixed $id) {
        return $this->readById($id);
    }
    public function getAll(){
        return $this->readAll();
    }
}