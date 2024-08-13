<?php
namespace App\Models;

use Framework\Database\Model;

class MainModel extends Model
{
    protected string $table = 'main';

    protected $fillable = [
				'id',
				'name',
		];

}