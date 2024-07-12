<?php

namespace Framework\Database;

use mysqli;

class DB
{
    private string $table;
    private array $parametrs;
    protected function sqlConnect(): mysqli
    {
        $conn = new mysqli(DB_LOCATION, DB_USER, DB_PASSWORD, DB_NAME);
        return $conn;
    }
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
        $conn = $this->sqlConnect();
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