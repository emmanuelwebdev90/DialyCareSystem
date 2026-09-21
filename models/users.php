<?php

require_once './core/crud.php';

class Users extends CRUD
{
    public function __construct(
        public int $id = 0,
        public String $nombre_completo = "",
        public String $email = "",
        public String $password_hash = "",
        public int $rol_id = 0,
        public String $activo = "",

    ) {
        parent::__construct('usuarios');
    }

    private function HashPassword(String $password)
    {
        # return password_hash($password, PASSWORD_BCRYPT);
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function VerifyPassword(String $password, String $hash)
    {
        # verify if the password matches the hash for login purposes
        return password_verify($password, $hash);
    }

    public function createUser()
    {
        $columns = "nombre_completo, email, password_hash, rol_id, activo";
        $values = ":nombre_completo, :email, :password_hash, :rol_id, :activo";
        $data = [
            ':nombre_completo' => $this->nombre_completo,
            ':email' => $this->email,
            ':password_hash' => $this->HashPassword($this->password_hash),
            ':rol_id' => $this->rol_id,
            ':activo' => ($this->activo) // Hash the password before storing it in the database
        ];
        $this->create($columns, $values, $data);
    }

    public function updateUser()
    {
        $set = "nombre_completo = :nombre_completo, email = :email, password_hash = :password_hash, rol_id = :rol_id, activo = :activo";
        $data = [

            ':nombre_completo' => $this->nombre_completo,
            ':email' => $this->email,
            ':password_hash' => $this->HashPassword($this->password_hash), // Hash the password before storing it in the database
            ':rol_id' => $this->rol_id,
            ':activo' => ($this->activo),
            ':id' => $this->id
        ];
        $this->update($set, $data);
    }

    public function deleteUser()
    {
        $this->delete($this->id);
    }

    public function getUserById()
    {
        return $this->readById($this->id);
    }
    public function getAllUsers()
    {
        return $this->readAll();
    }

    public function getUserByEmail(String $email)
    {
        // Fetch a user by email for login purposes 
        // Use prepared statements to prevent SQL injection
        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
