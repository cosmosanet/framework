<?php

namespace Framework\Database;

use mysqli;

class Model {
    protected string $table;
    protected array $fillable;
    protected string $conditions;
    public function table(string $name): Model 
    {
        $this->table = $name;
        return $this;
    }
    public function where(string $firstOperator, string $value, string $secondOperator): Model 
    {
        $sql = 'WHERE ' . strval($firstOperator) . ' ' . $value . ' ' . strval($secondOperator) . ' ';
        if(empty($this->conditions)) {
            $this->conditions = $sql;
        } else {
            $this->conditions = $this->conditions . ' ' . $sql;
        }
        return $this;
    }
    public function orWhere(string $firstOperator, string $value, string $secondOperator): Model 
    {
        $sql =  'OR ' . strval($firstOperator) . ' ' . $value . ' ' . strval($secondOperator) . ' ';
        $this->conditions = $this->conditions . $sql;
        return $this;
    }
    public function andWhere(string $firstOperator, string $value, string $secondOperator): Model 
    {
        $sql = 'AND ' . strval($firstOperator) . ' ' . $value . ' ' . strval($secondOperator) . ' ';
        $this->conditions = $this->conditions . $sql;
        return $this;
    }
    public function join(string $table): Model
    {
        $sql = ' JOIN ' . $table;
        if(empty($this->conditions)) {
            $this->conditions = $sql;
        } else {
            $this->conditions = $this->conditions . $sql;
        }
        return $this;
    }
    public function on(string $firstOperator, string $value, string $secondOperator): Model
    {
        $sql = ' ON ' . $firstOperator . ' ' . $value . ' ' . $secondOperator;
        $this->conditions = $this->conditions . $sql;
        return $this;
    }
    public function insert(array $arr): void 
    {
        foreach ($arr as $key => $value) {
            if (is_null($value)){ $arr[$key] = "NULL";
            } else {
                $arr[$key] = "'" . $arr[$key] . "'";
            }
        }
        $keys =  implode(', ',array_keys($arr));
        $values = implode(', ',array_values($arr));
        $sql = "INSERT INTO " . $this->table . " ( " . $keys . ") VALUES " . "(" . $values . ");";
        $conn = $this->sqlConnect();
        $conn->query($sql);
        mysqli_close($conn);
    }
    public function delete(): void 
    {
        $sql = 'DELETE';
        $sql = $sql . ' FROM ' . $this->table;
        if(!empty($this->conditions)) {
            $sql = $sql . ' ' . $this->conditions;
        }
    }
    public function get(?array $arr = null): array  
    {
        $sql = 'SELECT';
        if (empty($arr)) {
            $sql = $sql . ' * ' ;
        } else {
            $column = implode(', ', $arr);
            $sql = $sql . ' ' .  $column ;
        }
        $sql = $sql . ' FROM ' . $this->table;
        if(!empty($this->conditions)) {
            $sql = $sql . ' ' . $this->conditions;
        }
        $conn = $this->sqlConnect();
        $result = $conn->query($sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        mysqli_close($conn);
        return $rows;
    }
    private function sqlConnect(): mysqli 
    {
        $conn = new mysqli(DB_LOCATION, DB_USER, DB_PASSWORD, DB_NAME);
        return $conn;
    }
    public function count(): int 
    { 
        $sql = 'SELECT COUNT(*) ';
        $sql = $sql . ' FROM ' . $this->table;
        if(!empty($this->conditions)) {
            $sql = $sql . ' ' . $this->conditions;
        }
        $conn = $this->sqlConnect();
        $result = $conn->query($sql);
        mysqli_close($conn);
        return (int)mysqli_fetch_array($result)['COUNT(*)'];
    }
    public function toSql(?array $arr = null): string 
    {
        $sql = 'SELECT';
        if (empty($arr)) {
            $sql = $sql . ' * ' ;
        } else {
            $column = implode(', ', $arr);
            $sql = $sql . ' ' .  $column ;
        }
        $sql = $sql . ' FROM ' . $this->table;
        if(!empty($this->conditions)) {
            $sql = $sql . ' ' . $this->conditions;
        }
        return $sql;
    }
}