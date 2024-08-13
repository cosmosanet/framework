<?php
namespace App\Models;

use Framework\Database\Model;

class User extends Model
{
    protected string $table = 'user';
    
    protected $fillable = [
        'id',
        'name',
    ];

}
