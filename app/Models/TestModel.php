<?php
namespace App\Models;

include_once 'vendor\framework\database\Model.php';
use Framework\Database\Model;

class TestModel extends Model
{
    protected string $table = 'user';
    protected array $fillable = ['id', 'name'];

}