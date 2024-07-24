<?php

namespace Framework\Database;

use Error;
use mysqli;

class DB
{
    private string $table;
    private array $parametrs;
 
    public function table(string $name): DB
    {
        $this->table = $name;
        return $this;
    }
    public function string($name): DB
    {
        $this->parametrs[$name] = 'STRING';
        return $this;
    }
    public function int()
    {

    }
    public function getPatametr(): array
    {
        return $this->parametrs;
    }
    public function create(): void
    {
        $sql = 'CREATE TABLE ' . DB_NAME . $this->table . '(';
        $sql = "";
        foreach ($this->parametrs as $key => $value) {
            $sql = $sql . ' ' . $key . ' ' . $value;
        }
        $conn = DBSingleton::connect();
        $conn->query($sql);
        mysqli_close($conn);
    }
    public function toSql(): string
    {
        $sql = 'CREATE TABLE ' . DB_NAME . $this->table . '(';
        foreach ($this->parametrs as $key => $value) {
            $sql = $sql . ' ' . $key . ' ' . $value;
        }
        return $sql . ')';
    }


}