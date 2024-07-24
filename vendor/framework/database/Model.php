<?php

namespace Framework\Database;

use Framework\Database\DB;

class Model extends DB
{
    protected string $table;
    protected $fillable;
    protected string $conditions;
    protected string $joins;
    protected string $action;
    protected string $sqlOperator;
    protected string $insertValues;
    public function table(string $name): Model
    {
        $this->table = ' ' . $name;
        return $this;
    }
    public function where(string $firstOperator, string $value, string $secondOperator): Model
    {
        $sql = 'WHERE ' . strval($firstOperator) . ' ' . $value . ' ' . strval($secondOperator) . ' ';
        if (empty($this->conditions)) {
            $this->conditions = $sql;
        } else {
            $this->conditions = $this->conditions . ' ' . $sql;
        }
        return $this;
    }
    public function orWhere(string $firstOperator, string $value, string $secondOperator): Model
    {
        $sql = 'OR ' . strval($firstOperator) . ' ' . $value . ' ' . strval($secondOperator) . ' ';
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
        if (empty($this->joins)) {
            $this->joins = $sql;
        } else {
            $this->joins = $this->joins . $sql;
        }
        return $this;
    }
    public function on(string $firstOperator, string $value, string $secondOperator): Model
    {
        $sql = ' ON ' . $firstOperator . ' ' . $value . ' ' . $secondOperator;
        $this->joins .= $sql;
        return $this;
    }
    public function insert(array $arr, ?bool $toSql = null): ?string
    {
        foreach ($arr as $key => $value) {
            if (is_null($value)) {
                $arr[$key] = "NULL";
            } else {
                $arr[$key] = "'" . $arr[$key] . "'";
            }
        }
        $this->action = "INSERT INTO";
        $keys = implode(', ', array_keys($arr));
        $values = implode(', ', array_values($arr));
        $this->fillable = " ( " . $keys . ") ";
        $this->insertValues = "(" . $values . ");";
        $this->sqlOperator = " VALUES ";
        $sql = $this->sqlBuild();
        if ($toSql) {
            return $sql;
        }
        $conn = DBSingleton::connect();
        $conn->query($sql);
        mysqli_close($conn);
    }
    public function delete(?bool $toSql = null): ?string
    {
        $this->action = 'DELETE';
        $this->sqlOperator = ' FROM ';
        $sql = $this->sqlBuild();
        if ($toSql) {
            return $sql;
        }
        $conn = DBSingleton::connect();
        $conn->query($sql);
        mysqli_close($conn);
    }
    public function get(?array $arr = null, ?bool $toSql = null): mixed
    {
        $this->action = 'SELECT';
        if (empty($this->fillable)) {
            if (empty($arr)) {
                $this->fillable = ' * ';
            }
            if (is_array($arr)) {
                $column = implode(', ', $arr);
                $this->fillable = ' ' . $column;
            }
        } else {
            $column = implode(', ', $this->fillable);
            $this->fillable = ' ' . $column;
        }
        $this->sqlOperator = ' FROM ';
        $sql = $this->sqlBuild();
        if ($toSql) {
            return $sql;
        }
        $conn = DBSingleton::connect();
        $result = $conn->query($sql);
        $rows = [];
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        mysqli_close($conn);
        return $rows;
    }
    public function count(?array $arr = null, ?bool $toSql = null): mixed
    {
        $this->action = 'SELECT';
        if (empty($this->fillable)) {
            if (empty($arr)) {
                $this->fillable = ' COUNT(*) ';
            }
            if (is_array($arr)) {
                $column = implode(', ', $arr);
                $this->fillable = ' COUNT(' . $column . ' )';
            }
        } else {
            $column = implode(', ', $this->fillable);
            $this->fillable = ' COUNT(' . $column . ' )';
        }
        $this->sqlOperator = ' FROM';
        $sql = $this->sqlBuild();
        if ($toSql) {
            return $sql;
        }
        $conn = DBSingleton::connect();
        $result = $conn->query($sql);
        mysqli_close($conn);
        return (int) mysqli_fetch_array($result)['COUNT(*)'];   
        
    }
    protected function sqlBuild(): string
    {
        $sql = '';
        if (!empty($this->action)) {
            $sql .= $this->action;
        }
        if ($this->action == 'SELECT' || $this->action == 'COUNT(*)') {
            if (!empty($this->fillable)) {
                $sql .= $this->fillable;
            }
            if (!empty($this->sqlOperator)) {
                $sql .= $this->sqlOperator;
            }
            if (!empty($this->table)) {
                $sql .= $this->table;
            }
            if (!empty($this->conditions)) {
                $sql .= $this->conditions;
            }
            if (!empty($this->joins)) {
                $sql .= $this->joins;
            }
        }
        if ($this->action == 'INSERT INTO') {
            if (!empty($this->table)) {
                $sql .= $this->table;
            }
            if (!empty($this->fillable)) {
                $sql .= $this->fillable;
            }
            if (!empty($this->sqlOperator)) {
                $sql .= $this->sqlOperator;
            }
            if (!empty($this->insertValues)) {
                $sql .= $this->insertValues;
            }
        }
        return $sql;
    }
}