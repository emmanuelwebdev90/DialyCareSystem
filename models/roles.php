<?php
require_once './core/crud.php';

class Roles extends CRUD {
    public function __construct(
        public  $id='0',
        public  $nombre_rol=""
    ) {
        parent::__construct('roles');
    }

    public function createRole() {
        $columns = "nombre_rol";
        $values = ":nombre_rol";
        $data = [
            ':nombre_rol' => $this->nombre_rol,
        ];
        $this->create($columns, $values, $data);
    }

    public function updateRole() {
        $set = "nombre_rol = :nombre_rol";
        $data = [
            ':nombre_rol' => $this->nombre_rol,
            ':id' => $this->id
        ];
        $this->update($set, $data);
    }   

    public function deleteRole() {
        $this->delete($this->id);
    }

    public function getRoleById(mixed $id) {
        return $this->readById($id);
    }
    public function getAll(){
        return $this->readAll();
    }
}