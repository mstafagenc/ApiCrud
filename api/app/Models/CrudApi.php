<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrudApi extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'desc', 'image'];
}
