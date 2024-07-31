<?php
namespace App\Models;

include_once 'vendor\framework\database\Model.php';
use Framework\Database\Model;

class User extends Model
{
    protected string $table = 'user';
    protected $fillable =
        [
            'id',
            'name',
        ];

}
