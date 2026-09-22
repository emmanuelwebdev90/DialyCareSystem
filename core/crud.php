<?php
require_once('./core/connection.php');

class CRUD extends Connection
{
    public mixed $pdo;

    public function __construct(
        public  $table
    ) {

        $this->pdo = $this->connect();
    }

    public function readAll()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Read all failed: " . $e->getMessage());
        }
    }

    public function readById(mixed $id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Read by ID failed: " . $e->getMessage());
        }
    }

    public function delete(mixed $id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Delete failed: " . $e->getMessage());
        }
    }

    public function create(mixed $columns,mixed  $values,mixed  $data)
    {
        try {
            $stm = $this->pdo->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$values})");
            $stm->execute($data);
        } catch (PDOException $e) {
            $message = ['type' => 'error', 'message' => 'Error: ' . $e->getMessage(), 'class' =>'a-danger'];
            // regresa al formulario con el error como mensaje
            header("location: index.php?controller=user&action=form_create_user&message={$message['message']}&cls={$message['class']}");
            //die("Create failed: " . $e->getMessage());
        }
    }

    public function update(mixed $set, mixed $data)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE {$this->table} SET {$set} WHERE id = :id");
            $stmt->execute($data);
        } catch (PDOException $e) {
            die("Update failed: " . $e->getMessage());
        }
    }
}
