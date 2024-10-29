<?php

namespace App\Models;

use mysqli;

class Model {


    protected $db_host = DB_HOST;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;
    protected $db_name = DB_NAME;
    
    protected $query;
    
    protected $connection;

    protected $table;

    public function __construct() {
        $this->connection();
    }

    public function connection() {

        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql, $data = [], $params = null) {

        if($data){

            if($params === null){
                $params = str_repeat("s", count($data));
            }

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param($params, ...$data);
            $stmt->execute();
    
            $this->query = $stmt->get_result();

        } else {
            $this->query = $this->connection->query($sql);
        }
        
        return $this;

    }

    public function first() {
        return $this->query->fetch_assoc();
    }

    public function get() {
        return $this->query->fetch_all(MYSQLI_ASSOC);
    }

    // consultas preparadas

    public function all(){

        // SELECT * FROM contactos

        $sql = "SELECT * FROM {$this->table}";

        return $this->query($sql)->get();

    }

    public function find($id){

        // SELECT * FROM contactos WHERE id = 1

        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id], "i")->first();

    }

    public function where($columna, $operador, $valor=null){

        // SELECT * FROM contactos WHERE name = "Matias"

        if($valor == null){
            $valor = $operador;
            $operador = '=';
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$columna} {$operador} ?";
        $this->query($sql, [$valor], 's');

        return $this;

    }

    public function create($data){

        // INSERT INTO contactos (name, email, phone) VALUES ("", "", "")

        $columna = array_keys($data);
        $columna = implode(", ", $columna);

        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} ({$columna}) VALUES (" . str_repeat('?, ',  count($values) - 1) . "?)";

        $this->query($sql, $values); 

        $insert_id = $this->connection->insert_id;

        return $this->find($insert_id);

    }

    public function update($id, $data){

        // UPDATE contactos SET name = ?, email = ?, phone = ? WHERE id = 1

        $filtros = [];

        foreach ($data as $key => $value) {
            
            $filtros[] = "{$key} = ?";

        }

        $filtros  = implode(', ', $filtros);

        $sql = "UPDATE {$this->table} SET {$filtros} WHERE id = ?";

        $values = array_values($data);

        $values[] = $id;

        $this->query($sql, $values); // esto es lo que hace que active todo lo anterior, que pase realmente. 

        return $this->find($id);
    }

    public function delete($id){
        
        // DELETE FROM contactos WHERE id = 1

        $sql = "DELETE FROM {$this->table} WHERE id = ?";

        $this->query($sql, [$id], "i");

    }
}
