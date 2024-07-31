<?php

namespace Framework\Database;

class DB
{
    private string $table;
    private array $parametrs;
 
    public function table(string $name): DB
    {
        $this->table = $name;
        return $this;
    }
    public function string(string $name, ?int $count = null): DB
    {
        $this->parametrs[$name] = 'varchar';
        if ($count) {
            $this->parametrs[$name] .= ' (' . $count . ')';
        }
        $this->parametrs[$name] .= ' (' . 255 . ')';
        return $this;
    }
    public function int(string $name): DB
    {
        $this->parametrs[$name] .= ' (' . 255 . ')';
        return $this;
    }
    public function getPatametr(): array
    {
        return $this->parametrs;
    }
    public function create(): void
    {
        $sql = 'CREATE TABLE ' . $this->table . ' (';
        foreach ($this->parametrs as $key => $value) {
            $sql = $sql . $key . ' ' . $value . ', ';
        }
        $sql = rtrim($sql, " ,");
        $sql .= ');';
        $conn = DBSingleton::connect();
        $conn->query($sql);
        mysqli_close($conn);
        // echo $sql;
    }
    public function toSql(): string
    {
        $sql = 'CREATE TABLE ' . $this->table . ' (';
        foreach ($this->parametrs as $key => $value) {
            $sql = $sql . $key . ' ' . $value . ', ';
        }
        $sql = rtrim($sql, " ,");
        return $sql .= ');';
    }


}