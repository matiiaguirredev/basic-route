<?php

namespace App\Models;

use mysqli;

class Model {


    protected $db_host = DB_HOST;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;
    protected $db_name = DB_NAME;

    protected $connection;
    protected $query;

    // protected $sql, $data = [], $params = null; ya no estan mas usados en la función de paginate

    protected $select = "*";
    protected $where, $values = [];
    protected $orderBy = "";

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

        if ($data) {

            if ($params === null) {
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

    public function select(...$columna) {
        $this->select = implode(", ", $columna);
        return $this;
    }
    
    public function where($columna, $operador, $valor = null) {

        // SELECT * FROM contactos WHERE name = "Matias"

        if ($valor == null) {
            $valor = $operador;
            $operador = '=';
        }

        if ($this->where) {
            $this->where .= " AND $columna $operador ?";
        } else {
            $this->where = "$columna $operador ?";
        }

        $this->values = $valor;
        
        return $this;
    }

    public function orderBy($columna , $orden = "ASC") {
        // if (empty($this->orderBy)) {
        //     $this->orderBy = " ORDER BY {$columna} {$orden}";
        // }else {
        //     $this->orderBy.= ", {$columna} {$orden}";
        // }

        if($this->orderBy){
            $this->orderBy .= ", ORDER BY $columna $orden";
        }else {
            $this->orderBy = "$columna $orden";
        }
        return $this;
    }

    public function first() {
        if (empty($this->query)) {

            $sql = "SELECT $this->select FROM $this->table";

            if($this->where){
                $sql .= " WHERE $this->where";
            }

            if($this->orderBy){
                $sql .= " ORDER BY $this->orderBy";
            }

            $this->query($sql, $this->values);
        }

        return $this->query->fetch_assoc();
    }

    public function get() {

        if (empty($this->query)) {

            $sql = "SELECT $this->select FROM $this->table";

            if($this->where){
                $sql .= " WHERE $this->where";
            }

            if($this->orderBy){
                $sql .= " ORDER BY $this->orderBy";
            }

            $this->query($sql, $this->values);
        }
        return $this->query->fetch_all(MYSQLI_ASSOC);
    }

    public function paginate($cant = 10) {

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        // if ($this->sql) {
        //     $sql = $this->sql . ($this->orderBy ? $this->orderBy : '') . " LIMIT " . ($page - 1) * $cant .  ",$cant";
        //     $data = $this->query($sql, $this->data, $this->params)->get();
        // } else {
        //     $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM {$this->table} " . ($this->orderBy ? $this->orderBy : '') . " LIMIT " . ($page - 1) * $cant .  ",$cant";
        //     $data = $this->query($sql)->get();
        // }

        if (empty($this->query)) {

            $sql = "SELECT SQL_CALC_FOUND_ROWS $this->select FROM $this->table";

            if($this->where){
                $sql .= " WHERE $this->where";
            }

            if($this->orderBy){
                $sql .= " ORDER BY $this->orderBy";
            }

            $sql .= " LIMIT " . ($page - 1) * $cant .  ",$cant";


            $data = $this->query($sql, $this->values)->get();
        }

        $total = $this->query("SELECT FOUND_ROWS() as total")->first()['total'];

        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, '/');

        if (strpos($uri, "?")) {
            $uri = substr($uri, 0, strpos($uri, "?"));
        }

        $last_page = ceil($total / $cant);

        return [
            "total" => $total,
            "from" => ($page - 1) * $cant + 1,
            "to" => ($page - 1) * $cant + count($data),
            "current_page" => $page,
            "last_page" => $last_page,
            "next_page_url" => $page < $last_page ? "/" . $uri . "?page=" . $page + 1 : null,
            "prev_page_url" => $page > 1 ? "/" . $uri . "?page=" . $page - 1 : null,
            "data" => $data,
        ];
    }

    // consultas preparadas

    public function all() {

        // SELECT * FROM contactos

        $sql = "SELECT * FROM {$this->table}";

        return $this->query($sql)->get();
    }

    public function find($id) {

        // SELECT * FROM contactos WHERE id = 1

        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id], "i")->first();
    }

    public function create($data) {

        // INSERT INTO contactos (name, email, phone) VALUES ("", "", "")

        $columna = array_keys($data);
        $columna = implode(", ", $columna);

        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} ({$columna}) VALUES (" . str_repeat('?, ',  count($values) - 1) . "?)";

        $this->query($sql, $values);

        $insert_id = $this->connection->insert_id;

        return $this->find($insert_id);
    }

    public function update($id, $data) {

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

    public function delete($id) {

        // DELETE FROM contactos WHERE id = 1

        $sql = "DELETE FROM {$this->table} WHERE id = ?";

        $this->query($sql, [$id], "i");
    }
}
